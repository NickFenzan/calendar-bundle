<?php

namespace MillerVein\CalendarBundle\Controller;

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
     * @Route("", name="calendar")
     * @Template("MillerVeinCalendarBundle:Calendar:base.html.twig")
     */
    public function calendarAction(Request $request) {
        $session = $request->getSession();
        $calendar = $this->getCalendarFromSession($session);

        $controls = $this->createForm('calendar',$calendar,[
            'action' => $this->generateUrl('calendar_post')
        ]);

        return [
            'calendar' => $calendar,
            'controls' => $controls->createView()
        ];
    }

    /**
     * @Route("/post", name="calendar_post")
     * @Method({"POST"})
     */
    public function postAction(Request $request) {
        $session = $request->getSession();
        $calendar = $this->getCalendarFromSession($session);

        $controls = $this->createForm('calendar',$calendar);
        $controls->handleRequest($request);
        if($controls->isValid()){
            $clicked = $controls->getClickedButton();
            if($clicked){
                switch($clicked->getName()){
                    case "previous";
                        $calendar->getDate()->sub(new \DateInterval("P1D"));
                        break;
                    case "next";
                        $calendar->getDate()->add(new \DateInterval("P1D"));
                        break;
                }
            }
            
            $session->set('calendar_date',$calendar->getDate());
            $session->set('calendar_site_id',$calendar->getSite()->getId());
        }
        
//        return new \Symfony\Component\HttpFoundation\Response();
        return $this->redirectToRoute("calendar");
    }

    protected function getCalendarFromSession(Session $session){
        $em = $this->getDoctrine()->getManager();

        $siteRepo = $em->getRepository("MillerVeinCalendarBundle:Site");
        $apptRepo = $em->getRepository("MillerVeinCalendarBundle:Appointment");

        $date = $session->get('calendar_date', new DateTime());
        $site = $session->get('calendar_site_id') ?
                $siteRepo->find($session->get('calendar_site_id')) :
                $siteRepo->findOneBy([]);

        return new Calendar($date, $site, $apptRepo);
    }
}
