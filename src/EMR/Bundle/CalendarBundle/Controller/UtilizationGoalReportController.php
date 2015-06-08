<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use EMR\Bundle\CalendarBundle\Model\Reports\UtilizationGoalReport;
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
        $report->setStartDate(new \DateTime())
                ->setEndDate(new \DateTime())
                ->run();
        return [
            'report' => $report
        ];
    }

}
