<?php

namespace MillerVein\CalendarBundle\Controller;

use DateTime;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of AppointmentController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/calendar/appointment")
 */
class AppointmentController extends Controller {
    const CLASS_PATH = "MillerVein\\CalendarBundle\\Entity\\Appointment\\";
    
    /**
     * @Route("/patient/new", name="appointment_patient_new_form", options={"expose"=true})
     */
    public function newPatientAction(Request $request) {
        return $this->newFormAction($request,'Patient','appointment_patient');
    }
    
    /**
     * @Route("/patient/edit/{id}", name="appointment_patient_edit_form", options={"expose"=true})
     */
    public function editPatientAction(Request $request,$id) {
        return $this->editFormAction($request, $id,'Patient', 'appointment_patient');
    }
    
    /**
     * @Route("/provider/new", name="appointment_provider_new_form", options={"expose"=true})
     */
    public function newProviderAction(Request $request) {
        return $this->newFormAction($request,'Provider','appointment_provider');
    }
    
    /**
     * @Route("/provider/edit/{id}", name="appointment_provider_edit_form", options={"expose"=true})
     */
    public function editProviderAction(Request $request, $id) {
        return $this->editFormAction($request, $id,'Provider', 'appointment_provider');
    }
    
    protected function newFormAction(Request $request, $classname, $form) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $formOptions = array();
        $fullClassName = static::CLASS_PATH . $classname."Appointment";
        
        $formOptions['action'] = $this->generateUrl($form.'_new_form');
        $formOptions['type'] = $classname;
        
        $appt = new $fullClassName();
        
        if($request->request->get($form)){
            $formData = $request->request->get($form);
            $requestDateTime = $formData['date_time'];
            $requestColumn = $formData['column'];
        }else{
            $requestDateTime = $request->get('datetime');
            $requestColumn = $request->get('column');
        }
        
        $appt->setDateTime(new DateTime($requestDateTime));
        $column = $em->find("MillerVeinCalendarBundle:Column", $requestColumn);
        $appt->setColumn($column);
        $formOptions['calendar_column'] = $this->getCalendarColumn($session, $column);
        
        $form = $this->createForm($form, $appt,$formOptions);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appt);
            $em->flush();
            return $this->redirectToRoute("calendar");
        }else{
            foreach($form->getErrors(true) as $error){
                echo $error->getMessage();
            }
        }
        
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:new.html.twig",['form' => $form->createView()]);
    }
    
    protected function editFormAction(Request $request, $id, $classname, $form) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $fullClassName = static::CLASS_PATH . $classname."Appointment";
        $appt = $this->getDoctrine()->getManager()->find($fullClassName, $id);
        $column = $appt->getColumn();
        
        
        $formOptions = array();
        $formOptions['action'] = $this->generateUrl($form.'_edit_form',['id'=>$id]);
        $formOptions['calendar_column'] = $this->getCalendarColumn($session, $column);
        $formOptions['type'] = $classname;
        
        $form = $this->createForm($form, $appt, $formOptions);
        
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            switch($form->getClickedButton()->getName()){
                case 'delete':
                    $em->remove($appt);
                    $em->flush();
                    break;
                case 'submit':
                    $em->persist($appt);
                    $em->flush();
                    break;
            }
            return $this->redirectToRoute("calendar");
        }
        
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig",['form' => $form->createView()]);
    }
    
    protected function getCalendarColumn(Session $session, Column $column){
        $em = $this->getDoctrine()->getManager();
        $calendar = Calendar::getCalendarFromSession($em, $session);
        return $calendar->getCalendarColumnByColumn($column);
    }
    protected function getSchedulingIncrement(Session $session, Column $column){
        $calCol = $this->getCalendarColumn($session, $column);
        return $calCol->getHours()->getSchedulingIncrement();
    }
}
