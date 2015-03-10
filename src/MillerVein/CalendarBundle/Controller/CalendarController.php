<?php

namespace MillerVein\CalendarBundle\Controller;

use DateTime;
use MillerVein\CalendarBundle\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
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
        $em = $this->getDoctrine()->getManager();
        
        $date = $session->get('calendar_date', new DateTime());
        $columns = $em->getRepository("MillerVeinCalendarBundle:Column")->findAll();
        $sites = $em->getRepository("MillerVeinCalendarBundle:Site")->findAll();

        $calendar = new Calendar($date, $columns);
        return array('calendar' => $calendar, 'sites' => $sites);
    }
    
    /**
     * @Route("/post", name="calendar_post")
     * @Method({"POST"})
     */
    public function postAction(Request $request){
        $session = $request->getSession();
        
        if($request->request->get('date')){
            $session->set('calendar_date', new DateTime($request->request->get('date')));
        }
        
        return $this->redirectToRoute("calendar");
    }
    
}
