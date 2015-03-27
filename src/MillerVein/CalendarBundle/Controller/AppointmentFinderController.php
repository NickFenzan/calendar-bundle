<?php

namespace MillerVein\CalendarBundle\Controller;

use MillerVein\CalendarBundle\Model\AppointmentFinder;
use MillerVein\CalendarBundle\Model\AppointmentFinderRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of AppointmentController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/calendar/appointment_finder")
 */
class AppointmentFinderController extends Controller {

    /**
     * @Route("/form", name="appointment_finder_form", options={"expose"=true})
     */
    public function formAction() {
        $form = $this->createForm('appointment_finder_request');
        return $this->render('MillerVeinCalendarBundle::form.html.twig',
        ['form'=>$form->createView()]);
    }
    
    /**
     * @Route("/search", name="appointment_finder_search", options={"expose"=true})
     */
    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        
        $appt_request = new AppointmentFinderRequest();
        
        $form = $this->createForm('appointment_finder_request',$appt_request);
        $form->handleRequest($request);
        
        
        if($form->isValid()){
            $apptFinder = new AppointmentFinder($em);
            $appts = $apptFinder->findAppointments($appt_request);
            $results = $this->renderView('MillerVeinCalendarBundle:Calendar\AppointmentFinder:results.html.twig',['appts'=>$appts]);
            $response['status'] = 'Success';
            $response['html'] = $results;
        }else{
            $response['status'] = 'Error';
            $response['html'] = (string) $form->getErrors();
        }
        
        return new JsonResponse($response);
    }

}
