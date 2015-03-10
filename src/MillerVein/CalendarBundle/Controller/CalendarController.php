<?php

namespace MillerVein\CalendarBundle\Controller;

use MillerVein\CalendarBundle\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CalendarController extends Controller {
    /**
     * @Route("/calendar")
     * @Template()
     */
    public function calendarAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $columnRepo = $em->getRepository("MillerVeinCalendarBundle:Column");
        $columns = $columnRepo->findAll();
        
        $calendar = new Calendar(new \DateTime(), $columns);
        
        return array('calendar'=>$calendar);
    }

}
