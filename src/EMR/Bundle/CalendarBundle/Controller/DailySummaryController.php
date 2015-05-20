<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of DailySummaryController
 * @Route("/daily_summary")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DailySummaryController extends Controller {

    /**
     * @Route("", name="calendar_daily_summary")
     */
    public function indexAction(Request $request) {
        $calendarRequest = $this->get('emr.calendar.calendar_request');
        if ($request->getMethod() == 'GET') {
            $calendarRequest->fromSession($request->getSession());
        }
        $form = $this->createForm('calendar_request', $calendarRequest, [
            'method' => 'POST'
        ]);
        $form->add('submit','submit');

        $form->handleRequest($request);
        if ($form->isValid()) {
            $appointmentRepo = $this->get('appointment_repository');
            $appointments = $appointmentRepo->findAppointmentsBySiteDate(
                    $calendarRequest->getSite(), $calendarRequest->getDate(), null, $calendarRequest->getShowCancelled()
            );
            return $this->render('EMRCalendarBundle:Reports\\DailySummary:print.html.twig', [
                        'appointments' => $appointments,
                        'request' => $calendarRequest
            ]);
        } 
        return $this->render('EMRCalendarBundle:Reports\\DailySummary:index.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
