<?php

namespace EMR\Bundle\CalendarBundle\Controller\Report;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/report/calendar_utilization")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CalendarUtilizationController extends Controller {

    /**
     * @Route("")
     * @Method("GET")
     */
    public function indexAction() {

        $utilizationCalculator = $this->get('emr.calendar.utilization_calculator');
        $form = $this->createForm('utilization_calculator', $utilizationCalculator)
                ->add('submit', 'submit', ['label' => 'Go!']);

        return $this->render('EMRCalendarBundle:Reports:UtilizationCalculator\index.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("")
     * @Method("POST")
     */
    public function postAction(Request $request) {

        $utilizationCalculator = $this->get('emr.calendar.utilization_calculator');
        $form = $this->createForm('utilization_calculator', $utilizationCalculator)
                ->add('submit', 'submit', ['label' => 'Go!']);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $utilizationCalculator->calculate();
        }

        return $this->render('EMRCalendarBundle:Reports:UtilizationCalculator\index.html.twig', [
                    'form' => $form->createView(),
                    'calculator' => $utilizationCalculator,
        ]);
    }

}
