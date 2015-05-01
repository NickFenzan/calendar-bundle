<?php

namespace MillerVein\Bundle\CalendarBundle\Controller\Report;

use MillerVein\Bundle\CalendarBundle\Model\Reports\InvalidAppointment\InvalidAppointmentReport;
use MillerVein\Bundle\CalendarBundle\Model\Reports\InvalidAppointment\InvalidAppointmentRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of InvalidAppointmentReportController
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/report/invalid_appointment")
 */
class InvalidAppointmentReportController extends Controller {

    /**
     * @Route("")
     */
    public function indexAction(Request $request) {
        set_time_limit(0);
        $em = $this->getDoctrine()->getManager();

        $invApptRequest = new InvalidAppointmentRequest();
        $form = $this->createForm('invalid_appointment', $invApptRequest);
        $form->add('submit','submit');
        $report = new InvalidAppointmentReport($em, $this->get('validator'), $form);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $report->setRequest($invApptRequest);
            $report->run();
        }

        return $this->render('MillerVeinCalendarBundle:Reports:InvalidAppointment\report.html.twig', [
                    'report' => $report
        ]);
    }

}
