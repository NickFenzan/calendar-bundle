<?php

namespace MillerVein\Bundle\CalendarBundle\Controller;

use DateTime;
use MillerVein\Bundle\CalendarBundle\Entity\Appointment\PatientAppointment;
use MillerVein\Bundle\CalendarBundle\Entity\Category\PatientCategory;
use MillerVein\Bundle\CalendarBundle\Entity\Column;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AppointmentController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/calendar/appointment/patient")
 */
class AppointmentController extends Controller {

    const CLASS_PATH = "MillerVein\\CalendarBundle\\Entity\\";

    /**
     * @Route("/new", name="appointment_patient_new_form", options={"expose"=true})
     */
    public function newAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $appt = new PatientAppointment();
        $dateTime = new DateTime($request->query->get('datetime'));
        $column = $em->find("MillerVeinCalendarBundle:Column", $request->query->get('column'));

        $appt->setStart($dateTime);
        $appt->setColumn($column);

        $form = $this->createForm('appointment_patient', $appt, [
            'action' => $this->generateUrl('appointment_patient_new_submit')
        ]);
        return new JsonResponse([
            'action' => 'refreshForm',
            'html' => $this->renderView("MillerVeinCalendarBundle:Calendar/Appointment:new.html.twig", ['form' => $form->createView()])
        ]);
    }

    /**
     * @Route("/new/submit", name="appointment_patient_new_submit", options={"expose"=true})
     */
    public function newSubmitAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $appt = new PatientAppointment();
        $formOptions = ['action' => $this->generateUrl('appointment_patient_new_submit')];
        if($request->getClientIp() != '10.1.1.223'){
            $formOptions['validation_groups'] = ['new'];
        }
        $form = $this->createForm('appointment_patient', $appt, $formOptions);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($appt);
            $em->flush();
            return new JsonResponse([
                'action' => 'refreshCalendar',
            ]);
        } else {
            return new JsonResponse([
                'action' => 'refreshForm',
                'html' => $this->renderView("MillerVeinCalendarBundle:Calendar/Appointment:new.html.twig", ['form' => $form->createView()])
            ]);
        }
    }

    /**
     * @Route("/edit/{appt}", name="appointment_patient_edit_form", options={"expose"=true})
     */
    public function editAction(PatientAppointment $appt) {
        $form = $this->createForm('appointment_patient', $appt, [
            'action' => $this->generateUrl('appointment_patient_edit_submit',["appt"=>$appt->getId()])
        ]);
        return new JsonResponse([
            'action' => 'refreshForm',
            'html' => $this->renderView("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig", ['form' => $form->createView(),'id' => $appt->getId()])
        ]);
    }
    /**
     * @Route("/edit/{appt}/submit", name="appointment_patient_edit_submit", options={"expose"=true})
     */
    public function editSubmitAction(Request $request, PatientAppointment $appt) {
        $em = $this->getDoctrine()->getManager();
        //We need to validate twice here to determine if we allow edits on messed up ones
        $exisitingForm = $this->createForm('appointment_patient', $appt, [
            'validation_groups' => ['new'],
            'csrf_protection'   => false
        ])->submit([],false);
        
        $formOptions = [
            'action' => $this->generateUrl('appointment_patient_edit_submit',["appt"=>$appt->getId()])
        ];
        if($exisitingForm->isValid() && $request->getClientIp() != '10.1.1.223'){
            $formOptions['validation_groups'] = ['new'];
        }
        $form = $this->createForm('appointment_patient', $appt, $formOptions);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($appt);
            $em->flush();
            return new JsonResponse([
                'action' => 'refreshCalendar',
            ]);
        } else {
            return new JsonResponse([
                'action' => 'refreshForm',
                'html' => $this->renderView("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig", ['form' => $form->createView(),'id' => $appt->getId()])
            ]);
        }
    }
        
    /**
     * @Route("/info/{appt}", name="appointment_patient_info", options={"expose"=true})
     */
    public function infoAction(PatientAppointment $appt) {
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:patientInfo.html.twig", ['appt' => $appt]);
    }

    /**
     * @Route("/delete/{id}", name="appointment_delete", options={"expose"=true})
     */
    public function deleteAction(PatientAppointment $appt) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($appt);
        $em->flush();
        return $this->redirectToRoute("calendar");
    }

    /**
     * @Route("/allowed_categories/column/{column}", name="patient_allowed_categories", options={"expose"=true})
     */
    public function columnCategoryOptions(Column $column) {
        $em = $this->getDoctrine()->getManager();
        $allowedTags = $column->getTags();
        $catRepo = $em->getRepository('MillerVeinCalendarBundle:Category\PatientCategory');
        $allowedCats = $catRepo->findAllowedByTags($allowedTags);
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:optionsMenu.html.twig", ['options' => $allowedCats]);
    }

    /**
     * @Route("/allowed_durations", name="patient_allowed_duration", options={"expose"=true})
     */
    public function categoryDurationAction(Request $request) {
        $appt = new PatientAppointment();
        $form = $this->createForm('appointment_patient', $appt);
        $form->handleRequest($request);
        
        $category = $appt->getCategory();
        $column = $appt->getColumn();
        $date = $appt->getStart();
        
        $hours = $column->findHours($date);
        
//        $schedulingIncrement = $hours->getSchedulingIncrement();
        $schedulingIncrement = 15;
        
        //This whole mess down here will get fixed when i introduce duration rules
        $options = array();
        $defaultSelected = false;
        for ($i = $category->getMinDuration(); $i <= $category->getMaxDuration(); $i = $i + $schedulingIncrement) {
            $option = array();
            $option['id'] = $i;
            $hours = floor($i / 60);
            $minutes = $i % 60;
            $timeDescription = '';
            if ($hours > 0) {
                $timeDescription .= $hours . ' hour';
                if ($hours > 1) {
                    $timeDescription .= 's';
                }
                $timeDescription .= ' ';
            }
            if ($minutes > 0) {
                $timeDescription .= $minutes . ' minute';
                if ($minutes > 1) {
                    $timeDescription .= 's';
                }
            }
            $option['name'] = $timeDescription;
            if ($i == $category->getDefaultDuration() || (!$defaultSelected && $i > $category->getDefaultDuration())) {
                $option['selected'] = true;
                $defaultSelected = true;
            } else {
                $option['selected'] = false;
            }
            $options[] = $option;
        }
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:optionsMenu.html.twig", ['options' => $options]);
    }
    

    /**
     * @Route("/category/duration/default/{id}", name="category_default_duration", options={"expose"=true})
     */
    public function categoryDefaultDuration(PatientCategory $category){
        return new JsonResponse($category->getDefaultDuration());
    }
}
