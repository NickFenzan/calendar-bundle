<?php

namespace EMR\Bundle\CalendarBundle\Controller\Admin;

use EMR\Bundle\CalendarBundle\DomainManager\HoursManager;
use EMR\Bundle\CalendarBundle\Entity\Hours;
use EMR\Bundle\CalendarBundle\Form\Handler\HoursFormHandler;
use EMR\Bundle\CalendarBundle\Request\Admin\HoursAdminRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of HoursController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Route("/admin/hours")
 */
class HoursController extends Controller {

    /**
     * @Route("/", name="hours")
     */
    public function indexAction(Request $request) {
        $hoursAdminRequest = new HoursAdminRequest();
        $form = $this->createForm('hours_admin',$hoursAdminRequest);
        $form->add('submit','submit');
        
        $hours = array();
        $form->handleRequest($request);
        if($form->isValid()){
            /* @var $hoursManager HoursManager */
            $hoursManager = $this->get('hours_manager');
            $hours = $hoursManager->findByRequest($hoursAdminRequest);
        }
        
        return $this->render("EMRCalendarBundle:Admin:Hours\index.html.twig", [
                    'form' => $form->createView(),
                    'hours' => $hours,
        ]);
    }

    /**
     * @Route("/new", name="hours_new")
     */
    public function newAction(Request $request) {
        $form = $this->createForm('hours');
        return $this->formAction($form, $request);
    }

    /**
     * @Route("/edit/{hours}", name="hours_edit")
     */
    public function editAction(Hours $hours, Request $request) {
        $form = $this->createForm('hours', $hours);
        return $this->formAction($form, $request);
    }

    /**
     * @Route("/copy/{hours}", name="hours_copy")
     */
    public function copyAction(Hours $hours, Request $request) {
        $form = $this->createForm('hours', clone $hours);
        return $this->formAction($form, $request);
    }

    protected function formAction(FormInterface $form, Request $request){
        $form->add('submit', 'submit');
        /* @var $formHandler HoursFormHandler */
        $formHandler = $this->get('emr.calendar.form.handler.hours');
        if ($formHandler->handle($form, $request)) {
            return $this->redirectToRoute('hours');
        }
        return $this->render("EMRCalendarBundle:Admin:Hours\\form.html.twig", [
                    'form' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/delete/{hours}", name="hours_delete")
     */
    public function deleteAction(Hours $hours, Request $request) {
        /* @var $hoursManager HoursManager */
        $hoursManager = $this->get('hours_manager');
        $hoursManager->delete($hours);
        return $this->redirect($request->headers->get('referer'));
    }
    

}
