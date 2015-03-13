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
        $fullClassName = static::CLASS_PATH . $classname;
        
        $formOptions['action'] = $this->generateUrl($form.'_new_form');
        
        $appt = new $fullClassName();
        $appt->setDateTime(new DateTime($request->get('datetime')));
        if($request->get('column')){
            $em = $this->getDoctrine()->getManager();
            $col = $em->find("MillerVeinCalendarBundle:Column", $request->get('column'));
            $appt->setColumn($col);
            $formOptions['scheduling_increment'] = $this->getSchedulingIncrement($session, $col);
        }
        
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
        $fullClassName = static::CLASS_PATH . $classname;
        $appt = $this->getDoctrine()->getManager()->find($fullClassName, $id);
        $column = $appt->getColumn();
        
        
        $formOptions = array();
        $formOptions['action'] = $this->generateUrl($form.'_edit_form',['id'=>$id]);
        $formOptions['scheduling_increment'] = $this->getSchedulingIncrement($session, $column);
        
        $form = $this->createForm($form, $appt, $formOptions);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appt);
            $em->flush();
            return $this->redirectToRoute("calendar");
        }
        
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig",['form' => $form->createView()]);
    }
    
    protected function getSchedulingIncrement(Session $session, Column $column){
        $em = $this->getDoctrine()->getManager();
        $calendar = Calendar::getCalendarFromSession($em, $session);
        $calCol = $calendar->getCalendarColumnByColumn($column);
        return $calCol->getHours()->getSchedulingIncrement();
    }
}
