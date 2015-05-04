<?php

namespace EMR\Bundle\PatientTrackerBundle\Controller;

use EMR\Bundle\EMRBundle\Entity\Site;
use EMR\Bundle\PatientTrackerBundle\Entity\Room;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/room")
 */
class RoomController extends Controller{
    /**
     * @Route("/")
     */
    public function indexAction(){
        $siteForm = $this->createForm('site',null,[
            'action' => $this->generateUrl('rooms_site_index')
        ]);
        return $this->render('MillerVeinPatientTrackerBundle:Room:index.html.twig',[
            'site_form' => $siteForm->createView()
        ]);
    }
    /**
     * @Route("/site_rooms", name="rooms_site_index")
     */
    public function siteRoomIndexAction(Request $request){
        $siteForm = $this->createForm('site');
        $siteForm->handleRequest($request);
        $data = $siteForm->getData();
        $roomRepo = $this->getDoctrine()->getRepository('MillerVeinPatientTrackerBundle:Room');
        $rooms = $roomRepo->findRoomBySite($data['site']);
        return $this->render('MillerVeinPatientTrackerBundle:Room:siteIndex.html.twig',[
            'site' => $data['site'],
            'rooms' => $rooms
        ]);
    }
    
    /**
     * @Route("/new/{site}", name="rooms_add")
     * @Method({"GET"})
     */
    public function newRoomAction(Site $site){
        $room = new Room();
        $room->setSite($site);
        $form = $this->createForm('room',$room,[
            'action' => $this->generateUrl('rooms_add_submit')
        ]);
        return $this->render('MillerVeinPatientTrackerBundle:Room:new.html.twig',[
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/new", name="rooms_add_submit")
     * @Method({"POST"})
     */
    public function newRoomSubmitAction(Request $request){
        $room = new Room();
        $form = $this->createForm('room',$room);
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($room);
            $em->flush();
            return new Response();
        }else{
            return $this->render('MillerVeinPatientTrackerBundle:Room:new.html.twig',[
                'form' => $form->createView()
            ]);
        }
    }
    /**
     * @Route("/edit/{room}", name="rooms_edit")
     */
    public function editRoomAction(Room $room){
        echo $room->getName();
        return new Response();
    }
    /**
     * @Route("/delete/{room}", name="rooms_delete")
     */
    public function deleteRoomAction(Room $room){
        $em = $this->getDoctrine()->getManager();
        $em->remove($room);
        $em->flush();
        return new Response();
    }
}