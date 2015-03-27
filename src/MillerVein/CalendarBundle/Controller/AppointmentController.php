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
     * @Route("/{type}/new", name="appointment_new_form", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function newAction(Request $request,$type) {
        $em = $this->getDoctrine()->getManager();
        $classname = ucfirst($type);
        $form = 'appointment_'.$type;
        $session = $request->getSession();
        $formOptions = array();
        $fullClassName = static::CLASS_PATH . $classname."Appointment";
        
        $formOptions['action'] = $this->generateUrl('appointment_new_form',array('type'=>$type));
        $formOptions['type'] = $classname;
        
        $appt = new $fullClassName();
        
        if($request->request->get($form)){
            $formData = $request->request->get($form);
            $requestDateTime = $formData['start'];
            $requestColumn = $formData['column'];
        }else{
            $requestDateTime = $request->get('datetime');
            $requestColumn = $request->get('column');
        }
        
        $appt->setStart(new DateTime($requestDateTime));
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
    
    /**
     * @Route("/{type}/edit/{id}", name="appointment_edit_form", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function editAction(Request $request,$type, $id) {
        $em = $this->getDoctrine()->getManager();
        $classname = ucfirst($type);
        $form = 'appointment_'.$type;
        $session = $request->getSession();
        $fullClassName = static::CLASS_PATH . $classname."Appointment";
        $appt = $em->find($fullClassName, $id);
        $column = $appt->getColumn();
        
        
        $formOptions = array();
        $formOptions['action'] = $this->generateUrl('appointment_edit_form',['type'=>$type,'id'=>$id]);
        $formOptions['calendar_column'] = $this->getCalendarColumn($session, $column);
        $formOptions['type'] = $classname;
        
        $form = $this->createForm($form, $appt, $formOptions);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($appt);
            $em->flush();
            return $this->redirectToRoute("calendar");
        }else{
            echo $form->getErrorsAsString();
        }
        
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig",['form' => $form->createView(),'id'=>$id]);
    }
    
    /**
     * @Route("/{type}/info/{id}", name="appointment_info", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function infoAction($type,$id){
        $em = $this->getDoctrine()->getManager();
        $classname = ucfirst($type);
        $fullClassName = static::CLASS_PATH . $classname."Appointment";
        $appt = $em->find($fullClassName, $id);
        return $this->render("MillerVeinCalendarBundle:Calendar/Appointment:{$type}Info.html.twig",['appt' => $appt]);
    }
    
    /**
     * @Route("/{type}/delete/{id}", name="appointment_delete", options={"expose"=true}, defaults={"type" = "patient"})
     */
    public function deleteAction($type, $id){
        $classname = ucfirst($type);
        $em = $this->getDoctrine()->getManager();
        $fullClassName = static::CLASS_PATH . $classname."Appointment";
        $appt = $em->find($fullClassName, $id);
        $em->remove($appt);
        $em->flush();
        return $this->redirectToRoute("calendar");
    }
    
    /**
     * @Route("/category_duration/{id}", name="category_duration", options={"expose"=true})
     */
    public function categoryDurationAction($id){
        $cat = $this->getDoctrine()->getManager()->find('MillerVeinCalendarBundle:Category\Category',1);
        echo "Min: " . $cat->getMinDuration();
        echo "Max: " . $cat->getMaxDuration();
        echo "Default: " . $cat->getDefaultDuration();
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
