<?php

namespace MillerVein\PatientTrackerBundle\Controller;

use MillerVein\EMRBundle\Entity\Site;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrackerController extends Controller {

    /**
     * @Route("/")
     * @Route("/tracker")
     */
    public function indexAction() {
        $siteList = $this->createForm('site',null,[
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
     * @Route("/test")
     */
    public function testAction(){
        $em = $this->getDoctrine()->getManager();
        $siteRepo = $em->getRepository('MillerVeinEMRBundle:Site');
        $site = $siteRepo->findOneBy(['city'=>'Novi']);
        
        $stepRepo = $em->getRepository('MillerVeinPatientTrackerBundle:PatientTrackerStep');
        
        $steps = $stepRepo->findCurrentStepsBySite($site);
        
        foreach($steps as $step){
            echo $step->getId()."<br>";
        }
        return new \Symfony\Component\HttpFoundation\Response();
    }

}
