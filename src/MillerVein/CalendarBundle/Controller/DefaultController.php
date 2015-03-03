<?php

namespace MillerVein\CalendarBundle\Controller;

use DateTime;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use MillerVein\CalendarBundle\Entity\Hours;
use MillerVein\CalendarBundle\Entity\RecurranceRule;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/hours")
     * @Template()
     */
    public function hoursAction(Request $request)
    {
        $hours = new Hours();
        $output = '';
        
        $form = $this->createForm('hours', $hours)->add('save','submit');
        $form->handleRequest($request);
        
        if($form->isValid()){
        }
        
        return array('form' => $form->createView(), 'output'=>$output);
    }
    /**
     * @Route("/recurrance_rule")
     * @Template()
     */
    public function recurranceRuleAction(Request $request)
    {
        $rule = new RecurranceRule();
        $output = '';
        
        $form = $this->createForm('recurrance_rule', $rule)->add('save','submit');
        $form->handleRequest($request);
        echo $rule->getEscapedValue();
        
        if($form->isValid()){
            $calendar = new Calendar("MillerVeinEMR");
            $event = new Event();
            $event->setDtStart(new DateTime("2015-02-18 7:00"));
            $event->setDtEnd(new DateTime("2015-02-18 8:00"));
            $event->setSummary("test");
            $event->setRecurrenceRule($rule);
            $calendar->addComponent($event);
            $output = $calendar->render();
        }
        
        return array('form' => $form->createView(), 'output'=>$output);
    }
    
}
