<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use EMR\Bundle\CalendarBundle\Request\AppointmentMoverRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/appointment_mover")
 */
class AppointmentMoverController extends Controller {

    /**
     * @Route("")
     */
    public function indexAction(Request $request) {
        $apptRequest = new AppointmentMoverRequest();
        $form = $this->createForm('appointment_mover',$apptRequest)
                ->add('preview','submit')
                ->add('go','submit');
        $appts = [];
        $form->handleRequest($request);
        if($form->isValid()){
            $apptMover = $this->get('emr.calendar.appointment_mover');
            $apptMover->setRequest($apptRequest);
            $appts = $apptMover->getAppointmentsToMove();
            switch($form->getClickedButton()){
                case "go":
                    $apptMover->execute();
                    break;
                case "preview":
                default:
                    break;
            }
        }
        
        return $this->render('EMRCalendarBundle:Calendar:appointment_mover.html.twig', [
                    'form' => $form->createView(),
                    'appointments' => $appts
        ]);
    }
}
