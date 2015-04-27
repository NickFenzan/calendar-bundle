<?php

namespace MillerVein\PatientTrackerBundle\Controller;

use MillerVein\EMRBundle\Entity\Site;
use MillerVein\PatientTrackerBundle\Entity\PatientTrackerStep;
use MillerVein\PatientTrackerBundle\Entity\PatientTrackerVisit;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

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

    public function stepAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $roomRepo = $em->getRepository('MillerVeinPatientTrackerBundle:Room');
        $visitRepo = $em->getRepository('MillerVeinPatientTrackerBundle:PatientTrackerVisit');
        $room = $roomRepo->find($request->request['room']);
        $visit = $visitRepo->find($request->request['visit']);
        
        $step = new PatientTrackerStep();
        $step->setRoom($room);
        $step->setVisit($visit);
        if ($post['site'] && $post['room'] && $post['id']) {
            print_r($post);
            $visit = new PatientTrackerVisit($post['id']);
            $room = str_replace("_", " ", $post['room']);
            $step = new PatientTrackerStep();
            $step->setPatientTrackerVisit($visit);
            $step->setRoom($room);
            $step->setTimestamp(new DateTime());
            $step->save();

            $appt = $visit->getAppointment();

            switch ($room) {
                case "Lobby":
                    $apptStatus = "@";
                    break;
                case "Checked Out":
                    $apptStatus = ">";
                    break;
                default:
                    $apptStatus = "<";
                    break;
            }

            $appt->setApptStatus($apptStatus);
            $appt->setCurrentRoom($room);
            $appt->save();
        }
    }

}
