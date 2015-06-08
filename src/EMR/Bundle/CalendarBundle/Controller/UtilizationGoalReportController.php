<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/utilization/goals")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoalReportController extends Controller {

    /**
     * @Route("", name="utilization_goals_report")
     * @Template()
     */
    public function indexAction() {
        /* @var $report \EMR\Bundle\CalendarBundle\Model\Reports\UtilizationGoalReport */
        $report = $this->get('emr.calendar.utilization.report.goals');
        
        $report->setStartDate(new \DateTime("first day of this month"))
                ->setEndDate(new \DateTime("last day of this month"))
                ->run();
        return [
            'report' => $report
        ];
    }

}
