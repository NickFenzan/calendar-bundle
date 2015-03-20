<?php

namespace MillerVein\CalendarBundle\Controller;

use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
/**
 * Description of TestController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TestController extends Controller{
    /**
     * @Route("/test")
     */
    public function testAction(){
        $em = $this->getDoctrine()->getManager('default');
        $appt = new PatientAppointment();
        $patrepo = $this->getDoctrine()->getManager('openemr')->getRepository('MillerVeinEMRBundle:PatientData');
        $patient = $patrepo->find(1);
        
        $column = $em->getRepository("MillerVeinCalendarBundle:Column")->findOneBy(array());
        $status = $em->getRepository("MillerVeinCalendarBundle:AppointmentStatus")->findOneBy(array());
        $category = $em->getRepository("MillerVeinCalendarBundle:Category\PatientCategory")->findOneBy(array());
        
        $appt->setStatus($status);
        $appt->setDuration(15);
        $appt->setDateTime(new \DateTime());
        $appt->setCategory($category);
        $appt->setColumn($column);
        $appt->setPatient($patient);
        
        $em->persist($appt);
        $em->flush();
        
        return new Response('Success');
    }
}
