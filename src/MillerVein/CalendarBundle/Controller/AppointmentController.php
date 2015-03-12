<?php

namespace MillerVein\CalendarBundle\Controller;

use DateTime;
use MillerVein\CalendarBundle\Entity\Appointment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AppointmentController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/calendar/appointment")
 */
class AppointmentController extends Controller {

    /**
     * @Route("/new", name="appointment_new_form")
     * @Template("MillerVeinCalendarBundle:Calendar/Appointment:new.html.twig")
     */
    public function newFormAction(Request $request) {
        $appt = new Appointment();
        
        $appt->setDateTime(new DateTime($request->get('datetime')));
        
        if($request->get('column')){
            $em = $this->getDoctrine()->getManager();
            $col = $em->find("MillerVeinCalendarBundle:Column", $request->get('column'));
            $appt->setColumn($col);
        }
        
        $form = $this->createForm('appointment', $appt,[
            'action' => $this->generateUrl('appointment_new_form')
        ])->createView();
        return ['form' => $form];
    }
    
    public function newSaveAction(Request $request){
        
    }

    /**
     * @Route("/edit/{id}", name="appointment_edit_form")
     * @Template("MillerVeinCalendarBundle:Calendar/Appointment:edit.html.twig")
     */
    public function editFormAction($id) {
        $appt = $this->getDoctrine()->getManager()->find("MillerVeinCalendarBundle:Appointment", $id);
        $form = $this->createForm('appointment', $appt)->createView();
        $response = new JsonResponse();
        $response->setData(array(
            'form' => $this->render("MillerVeinCalendarBundle::form.html.twig", ['form' => $form])->getContent()
        ));
        return $response;
    }
    
}
