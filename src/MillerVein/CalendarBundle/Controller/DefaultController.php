<?php

namespace MillerVein\CalendarBundle\Controller;

use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Entity\Hours;
use MillerVein\CalendarBundle\Entity\RecurrenceRule;
use MillerVein\CalendarBundle\Entity\Site;
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
     * @Route("/recurrence_rule")
     * @Template()
     */
    public function recurrenceRuleAction(Request $request) {
        $rule = new RecurrenceRule();

        $form = $this->createForm('recurrence_rule', $rule)->add('save', 'submit');
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

}
