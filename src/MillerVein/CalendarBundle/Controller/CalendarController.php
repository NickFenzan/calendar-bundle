<?php

namespace MillerVein\CalendarBundle\Controller;

use DateInterval;
use DateTime;
use MillerVein\CalendarBundle\Entity\Appointment\AppointmentRepository;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\AppointmentFragmentBuilder;
use MillerVein\CalendarBundle\Model\CalendarRequest;
use MillerVein\CalendarBundle\Model\Collections\AppointmentFragmentCollection;
use MillerVein\CalendarBundle\Model\Collections\ColumnViewCollection;
use MillerVein\CalendarBundle\Model\Collections\TimeSlotCollection;
use MillerVein\CalendarBundle\Model\ColumnView;
use MillerVein\CalendarBundle\Model\DateTimeUtility;
use MillerVein\CalendarBundle\Model\TimeSlot;
use MillerVein\CalendarBundle\Model\TimeSlotCollectionFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/calendar")
 */
class CalendarController extends Controller {

    /**
     * @Route("", name="calendar", options={"expose"=true})
     * @Method({"GET"})
     */
    public function mainViewAction(Request $request) {
        $siteRepo = $this->getDoctrine()->getManager()->getRepository('MillerVeinEMRBundle:Site');
        $calendarRequest = new CalendarRequest($siteRepo);
        $session = $request->getSession();
        $calendarRequest->fromSession($session);
        $controls = $this->createForm('calendar_request', $calendarRequest, [
            'action' => $this->generateUrl('calendar_request')
        ]);
        $appointmentFinder = $this->createForm('appointment_finder_request');
        $calendarBuilder = $this->get('millervein.calendar.calendar_builder');
        $calendar = $calendarBuilder->buildCalendar($calendarRequest);
        

        return $this->render('MillerVeinCalendarBundle:Calendar:base.html.twig', [
                    'calendar' => $calendar,
                    'controls' => $controls->createView(),
                    'appointment_finder' => $appointmentFinder->createView()
        ]);
    }
 

    /**
     * @Route("", name="calendar_request", options={"expose"=true})
     * @Method({"POST"})
     */
    public function calendarRequest(Request $request) {
        $siteRepo = $this->getDoctrine()->getManager()->getRepository('MillerVeinEMRBundle:Site');
        $calendarRequest = new CalendarRequest($siteRepo);
        $session = $request->getSession();
        $controls = $this->createForm('calendar_request', $calendarRequest);
        $controls->handleRequest($request);
        $calendarRequest->toSession($session);
        return $this->redirectToRoute('calendar');
    }

    /**
     * @Route("/ajax/post", name="calendar_ajax_post", options={"expose"=true})
     * @ Template("MillerVeinCalendarBundle:Calendar:calendar.html.twig")
     */
    public function calendarOnlyAction(Request $request) {
        $siteRepo = $this->getDoctrine()->getManager()->getRepository('MillerVeinEMRBundle:Site');
        $calendarRequest = new CalendarRequest($siteRepo);
        $calendarRequestForm = $this->createForm('calendar_request', $calendarRequest);
        $calendarRequestForm->handleRequest($request);
        $columns = $calendarRequest->getColumns();
        foreach ($columns as $column) {
            echo $column->getName();
        }
        return new Response();
//        // <editor-fold defaultstate="collapsed" desc="comment">
//        $session = $request->getSession();
//        $calendar = $this->getCalendarFromSession($session);
//
//        $controls = $this->createForm('calendar', $calendar);
//        $controls->handleRequest($request);
//        if ($controls->isValid()) {
//            $session->set('calendar_date', $calendar->getDate());
//            $session->set('calendar_site_id', $calendar->getSite()->getId());
//            $session->set('calendar_show_cancelled', $calendar->getShowCancelled());
//        }
//        
//        $calendar = $this->getCalendarFromSession($session);
//        return [
//            'calendar' => $calendar,
//        ];// </editor-fold>
    }

}
