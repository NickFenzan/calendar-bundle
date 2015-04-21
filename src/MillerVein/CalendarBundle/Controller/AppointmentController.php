<?php

namespace MillerVein\CalendarBundle\Controller;

use DateTime;
use MillerVein\CalendarBundle\Entity\Category\PatientCategory;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of AppointmentController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/calendar/appointment")
 */
class AppointmentController extends Controller {

    const CLASS_PATH = "MillerVein\\CalendarBundle\\Entity\\";

    /**
     * @Route("/{type}/new", name="appointment_new_form", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function newAction(Request $request, $type) {
        $em = $this->getDoctrine()->getManager();
        $classname = ucfirst($type);
        $form = 'appointment_' . $type;
        $session = $request->getSession();
        $formOptions = array();
        $fullClassName = static::CLASS_PATH . 'Appointment\\' . $classname . "Appointment";

        $formOptions['method'] = 'get';
        $formOptions['action'] = $this->generateUrl('appointment_new_form', array('type' => $type));
        $formOptions['type'] = $classname;

        $appt = new $fullClassName();
        if ($request->query->get($form)) {
            $formData = $request->query->get($form);
            $requestDateTime = ($request->get('datetime')) ? $request->get('datetime') : $formData['start'];
            $requestColumn = ($request->get('column')) ? $request->get('datetime') : $formData['column'];
        } else {
            $requestDateTime = $request->get('datetime');
            $requestColumn = $request->get('column');
        }

        $appt->setStart(new DateTime($requestDateTime));
        $column = $em->find("MillerVeinCalendarBundle:Column", $requestColumn);
        $appt->setColumn($column);
        $formOptions['calendar_column'] = $this->getCalendarColumn($session, $column);

        $form = $this->createForm($form, $appt, $formOptions);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appt);
            $em->flush();
            $response = [
                'action' => "refreshCalendar"
            ];
            return new JsonResponse($response);
//            return $this->redirectToRoute("calendar");
        } else {
            $response = [
                'action' => 'refreshForm',
                'html' => $this->renderView("MillerVeinCalendarBundle:Calendar/Appointment:new.html.twig", ['form' => $form->createView(), 'type' => $type])
            ];
//            return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:new.html.twig",['form' => $form->createView(),'type'=>$type]);
            return new JsonResponse($response);
        }
    }

    /**
     * @Route("/{type}/edit/{id}", name="appointment_edit_form", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function editAction(Request $request, $type, $id) {
        $em = $this->getDoctrine()->getManager();
        $classname = ucfirst($type);
        $form = 'appointment_' . $type;
        $session = $request->getSession();
        $fullClassName = static::CLASS_PATH . 'Appointment\\' .  $classname . "Appointment";
        $appt = $em->find($fullClassName, $id);
        $column = $appt->getColumn();


        $formOptions = array();
        $formOptions['method'] = 'get';
        $formOptions['action'] = $this->generateUrl('appointment_edit_form', ['type' => $type, 'id' => $id]);
        $formOptions['calendar_column'] = $this->getCalendarColumn($session, $column);
        $formOptions['type'] = $classname;

        $form = $this->createForm($form, $appt, $formOptions);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($appt);
            $em->flush();
            $response = [
                'action' => "refreshCalendar"
            ];
            return new JsonResponse($response);
//            return $this->redirectToRoute("calendar");
        } else {
//            echo $form->getErrorsAsString();
            $response = [
                'action' => 'refreshForm',
                'html' => $this->renderView("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig", ['form' => $form->createView(), 'id' => $id])
            ];
            return new JsonResponse($response);
        }

//        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig",['form' => $form->createView(),'id'=>$id]);
    }

    /**
     * @Route("/{type}/info/{id}", name="appointment_info", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function infoAction($type, $id) {
        $em = $this->getDoctrine()->getManager();
        $classname = ucfirst($type);
        $fullClassName = static::CLASS_PATH . 'Appointment\\' . $classname . "Appointment";
        $appt = $em->find($fullClassName, $id);
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:{$type}Info.html.twig", ['appt' => $appt]);
    }

    /**
     * @Route("/{type}/delete/{id}", name="appointment_delete", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function deleteAction($type, $id) {
        $classname = ucfirst($type);
        $em = $this->getDoctrine()->getManager();
        $fullClassName = static::CLASS_PATH . 'Appointment\\' . $classname . "Appointment";
        $appt = $em->find($fullClassName, $id);
        $em->remove($appt);
        $em->flush();
        return $this->redirectToRoute("calendar");
    }



    protected function getCalendarColumn(Session $session, Column $column) {
        $em = $this->getDoctrine()->getManager();
        $calendar = Calendar::getCalendarFromSession($em, $session);
        return $calendar->getCalendarColumnByColumn($column);
    }

    protected function getSchedulingIncrement(Session $session, Column $column) {
        $calCol = $this->getCalendarColumn($session, $column);
        return $calCol->getHours()->getSchedulingIncrement();
    }

    /**
     * @Route("/{type}/category/columns/{id}", name="category_columns", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function columnCategoryOptions($type,$id) {
        $classname = ucfirst($type);
        $em = $this->getDoctrine()->getManager();
        $fullClassName = static::CLASS_PATH . 'Category\\' .  $classname . "Category";
        /* @var $col \MillerVein\CalendarBundle\Entity\Column */
        $col = $em->find('MillerVeinCalendarBundle:Column', $id);
        $allowedTags = $col->getTags();
        $catRepo = $em->getRepository($fullClassName);
//        $catRepo = $em->getRepository('MillerVeinCalendarBundle:Category\Category');
        $allowedCats = $catRepo->findAllowedByTags($allowedTags);
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:optionsMenu.html.twig", ['options' => $allowedCats]);
//        return new \Symfony\Component\HttpFoundation\Response();
    }
    
    /**
     * @Route("/category/duration/{id}", name="category_duration", options={"expose"=true})
     */
    public function categoryDurationAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->find('MillerVeinCalendarBundle:Category\Category', $id);
        $column_id = $request->query->get('column');
        $column = $em->find('MillerVeinCalendarBundle:Column', $column_id);
        $dateRequest = $request->query->get('date');
        $date = ($dateRequest) ? new \DateTime($dateRequest) : new \DateTime();
        $calHours = $column->findHours($date);
        
        $options = array();
        $defaultSelected = false;
        for($i = $cat->getMinDuration();$i <= $cat->getMaxDuration();$i = $i + $calHours->getSchedulingIncrement()){
            $option = array();
            $option['id'] = $i;
            $hours = floor($i/60);
            $minutes =  $i % 60;
            $timeDescription = '';
            if($hours > 0){
                $timeDescription .= $hours . ' hour';
                if($hours > 1){
                    $timeDescription .= 's';
                }
                $timeDescription .= ' ';
            }
            if($minutes > 0){
                $timeDescription .= $minutes . ' minute';
                if($minutes > 1){
                    $timeDescription .= 's';
                }
            }
            $option['name'] = $timeDescription;
            if($i == $cat->getDefaultDuration() || (!$defaultSelected && $i > $cat->getDefaultDuration())){
                $option['selected'] = true;
                $defaultSelected = true;
            }else{
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
        return $category->getDefaultDuration();
    }
}
