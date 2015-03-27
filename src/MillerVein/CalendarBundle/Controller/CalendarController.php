<?php

namespace MillerVein\CalendarBundle\Controller;

use DateInterval;
use DateTime;
use MillerVein\CalendarBundle\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller {

    /**
     * @Route("", name="calendar", options={"expose"=true})
     * @Template("MillerVeinCalendarBundle:Calendar:base.html.twig")
     */
    public function calendarAction(Request $request) {
        $session = $request->getSession();
        $calendar = $this->getCalendarFromSession($session);
        $controls = $this->createForm('calendar', $calendar, [
            'action' => $this->generateUrl('calendar_post')
        ]);
        $appointmentFinder = $this->createForm('appointment_finder_request');
        
        return [
            'calendar' => $calendar,
            'controls' => $controls->createView(),
            'appointment_finder' => $appointmentFinder->createView()
        ];
    }
    
    /**
     * @Route("/ajax/post", name="calendar_ajax_post", options={"expose"=true})
     * @Template("MillerVeinCalendarBundle:Calendar:calendar.html.twig")
     */
    public function calendarOnlyAction(Request $request) {
        $session = $request->getSession();
        $calendar = $this->getCalendarFromSession($session);

        $controls = $this->createForm('calendar', $calendar);
        $controls->handleRequest($request);
        if ($controls->isValid()) {
            $session->set('calendar_date', $calendar->getDate());
            $session->set('calendar_site_id', $calendar->getSite()->getId());
            $session->set('calendar_show_cancelled', $calendar->getShowCancelled());
        }
        
        $calendar = $this->getCalendarFromSession($session);
        return [
            'calendar' => $calendar,
        ];
    }

    /**
     * @Route("/post", name="calendar_post")
     * @Method({"POST"})
     */
    public function postAction(Request $request) {
        $session = $request->getSession();
        $calendar = $this->getCalendarFromSession($session);

        $controls = $this->createForm('calendar', $calendar);
        $controls->handleRequest($request);
        if ($controls->isValid()) {
            $clicked = $controls->getClickedButton();
            if ($clicked) {
                switch ($clicked->getName()) {
                    case "previous";
                        $calendar->getDate()->sub(new DateInterval("P1D"));
                        break;
                    case "next";
                        $calendar->getDate()->add(new DateInterval("P1D"));
                        break;
                }
            }
            
            $session->set('calendar_date', $calendar->getDate());
            $session->set('calendar_site_id', $calendar->getSite()->getId());
            $session->set('calendar_show_cancelled', $calendar->getShowCancelled());
        }

//        return new \Symfony\Component\HttpFoundation\Response();
        return $this->redirectToRoute("calendar");
    }
    
    protected function getCalendarFromSession(Session $session){
        $em = $this->getDoctrine()->getManager();
        return Calendar::getCalendarFromSession($em,$session);
    }
}
