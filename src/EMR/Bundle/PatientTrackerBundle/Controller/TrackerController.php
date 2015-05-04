<?php

namespace EMR\Bundle\PatientTrackerBundle\Controller;

use EMR\Bundle\EMRBundle\Entity\Site;
use EMR\Bundle\PatientTrackerBundle\Entity\PatientTrackerStep;
use EMR\Bundle\PatientTrackerBundle\Entity\PatientTrackerVisit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackerController extends Controller {

    /**
     * @Route("/")
     * @Route("/tracker")
     */
    public function indexAction() {
        $siteList = $this->createForm('site', null, [
            'action' => $this->generateUrl('tracker_site_post')
        ]);
        return $this->render('MillerVeinPatientTrackerBundle:Tracker:tracker.html.twig', [
                    'site_list' => $siteList->createView()
//                    'All_Sites' => $siteRepo->findAll()
        ]);
    }

    /**
     * @Route("/tracker/site", name="tracker_site_post")
     * @Method({"POST"})
     */
    public function siteRoomIndexFormAction(Request $request) {
        $siteForm = $this->createForm('site');
        $siteForm->handleRequest($request);
        $data = $siteForm->getData();
        return $this->siteRoomIndexAction($data['site']);
    }

    /**
     * @Route("/tracker/site/{site}", name="tracker_site")
     * @Method({"GET"})
     */
    public function siteRoomIndexAction(Site $site) {
        $roomRepo = $this->getDoctrine()->getRepository('MillerVeinPatientTrackerBundle:Room');
        $rooms = $roomRepo->findRoomBySite($site);
        return $this->render('MillerVeinPatientTrackerBundle:Tracker:rooms.html.twig', [
                    "rooms" => $rooms
        ]);
    }

    /**
     * @Route("/timingCheck/{site}", name="patient_tracker_timing_check", options={"expose"=true})
     */
    public function timingCheckAction(Site $site) {
        $em = $this->getDoctrine()->getManager();
        $visitRepo = $em->getRepository('MillerVeinPatientTrackerBundle:PatientTrackerVisit');
        $visits = $visitRepo->findActiveVisitsBySite($site);

        $rooms = array();
        foreach ($visits as $visit) {
            /* @var $visit PatientTrackerVisit */
            $rooms[$visit->getCurrentStep()->getRoom()->getId()][] = $this->renderView('MillerVeinPatientTrackerBundle:Tracker:visit.html.twig', ['visit' => $visit]);
        }

        return new JsonResponse($rooms);
    }

    /**
     * @Route("/addStep", name="patient_tracker_add_step", options={"expose"=true})
     */
    public function stepAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $roomRepo = $em->getRepository('MillerVeinPatientTrackerBundle:Room');
        $visitRepo = $em->getRepository('MillerVeinPatientTrackerBundle:PatientTrackerVisit');
        
        $room = $roomRepo->find($request->request->get('room'));
        $visit = $visitRepo->find($request->request->get('visit'));
        
        if($room && $visit){
            $step = new PatientTrackerStep();
            $step->setRoom($room);
            $step->setVisit($visit);

            $em->persist($step);
            $em->flush();
        }
        
        return new Response();
    }
    
    /**
     * @Route("/checkout/{visit}", name="patient_tracker_checkout", options={"expose"=true})
     */
    public function checkoutAction(PatientTrackerVisit $visit) {
        $em = $this->getDoctrine()->getManager();
        
        $roomRepo = $em->getRepository('MillerVeinPatientTrackerBundle:Room');
        $statusRepo = $em->getRepository('MillerVeinCalendarBundle:AppointmentStatus');
        
        $appointment = $visit->getAppointment();
        $site = $appointment->getColumn()->getSite();
        $lobby = $roomRepo->findLobbyBySite($site);
        
        $checkedOut = $statusRepo->findOneBy(['name'=>'Checked out']);
        $appointment->setStatus($checkedOut);
        
        $step = new PatientTrackerStep();
        $step->setRoom($lobby);
        $step->setVisit($visit);
        
        $visit->setCheckedOut(true);
        
        $em->persist($appointment);
        $em->persist($visit);
        $em->persist($step);
        $em->flush();
        
        return new Response();
    }

}
