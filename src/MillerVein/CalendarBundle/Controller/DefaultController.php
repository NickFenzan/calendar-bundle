<?php

namespace MillerVein\CalendarBundle\Controller;

use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Entity\Hours;
use MillerVein\CalendarBundle\Entity\RecurranceRule;
use MillerVein\CalendarBundle\Entity\Site;
use MillerVein\CalendarBundle\Model\Calendar;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/hours")
     * @Template()
     */
    public function hoursAction(Request $request) {
        $hours = new Hours();

        $form = $this->createForm('hours', $hours)->add('save', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($hours);
            $em->flush();
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/recurrance_rule")
     * @Template()
     */
    public function recurranceRuleAction(Request $request) {
        $rule = new RecurranceRule();

        $form = $this->createForm('recurrance_rule', $rule)->add('save', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rule);
            $em->flush();
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/column")
     * @Template()
     */
    public function columnAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $column = new Column();

        $form = $this->createForm('column', $column)->add('save', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($column);
            $em->flush();
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/site")
     * @Template()
     */
    public function siteAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $site = new Site();

        $form = $this->createForm('site', $site)->add('save', 'submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($site);
            $em->flush();
        }

        return array('form' => $form->createView());
    }

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
