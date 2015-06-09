<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use EMR\Bundle\CalendarBundle\Entity\Repository\UtilizationGoalRepository;
use EMR\Bundle\CalendarBundle\Entity\Repository\UtilizationMetricRepository;
use EMR\Bundle\CalendarBundle\Entity\UtilizationMetric;
use Exception;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoalReport {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @var DateTime
     */
    protected $start_date;

    /**
     * @var DateTime
     */
    protected $end_date;

    /**
     * @var UtilizationMetricRepository 
     */
    protected $utilization_metric_repo;

    /**
     * @var UtilizationGoalRepository 
     */
    protected $utilization_goal_repo;

    /**
     * @var UtilizationCalculator
     */
    protected $utilization_calculator;

    /**
     * Array of metrics the report has built
     * @var array
     */
    protected $results;

    /**
     *
     * @var ArrayCollection
     */
    protected $metrics;

// </editor-fold>

    public function __construct(
    UtilizationMetricRepository $utilizationMetricRepo, UtilizationGoalRepository $utilizationGoalRepo, UtilizationCalculator $utilizationCalculator
    ) {
        $this->utilization_metric_repo = $utilizationMetricRepo;
        $this->utilization_goal_repo = $utilizationGoalRepo;
        $this->utilization_calculator = $utilizationCalculator;
        $this->metrics = new ArrayCollection();
        $this->results = array();
    }

// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getResults() {
        return $this->results;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setStartDate(DateTime $start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function setEndDate(DateTime $end_date) {
        $this->end_date = $end_date;
        return $this;
    }

// </editor-fold>

    public function run() {
        if (!isset($this->start_date) || !isset($this->end_date)) {
            throw new Exception("Start and end date must be set to run the report.");
        }
        $this->findMetrics();
        $this->buildResults();
    }

    protected function buildResults() {
        foreach ($this->metrics as $metric) {
            $result = new UtilizationGoalReportResult();
            $result->setName($metric->getName());
            $activeGoal = $this->findActiveGoalForMetric($metric);
            $result->setCurrent($this->calculateCurrent($metric));
            $result->setProjected($this->calculateProjected($metric));
            $result->setGoal(($activeGoal) ? $activeGoal->getGoal() : null);
            $this->results[] = $result;
        }
    }

    protected function findMetrics() {
        $this->metrics = $this->utilization_metric_repo->findMetricsWithGoalsInDateRange($this->start_date, $this->end_date);
    }

    protected function findActiveGoalForMetric(UtilizationMetric $metric) {
        return $this->utilization_goal_repo->findActiveGoalForMetricByDateRange($metric, $this->start_date, $this->end_date);
    }

    protected function setCalculatorColumnsForMetric(UtilizationMetric $metric) {
        $this->utilization_calculator->setColumns($metric->getColumns());
        $this->utilization_calculator->setTags($metric->getTags());
    }

    protected function calculateProjected(UtilizationMetric $metric) {
        $this->setCalculatorColumnsForMetric($metric);
        return $this->utilization_calculator
                ->setStartDate($this->start_date)
                ->setEndDate($this->end_date)
                ->calculate()
                ->getResult();
    }

    protected function calculateCurrent(UtilizationMetric $metric) {
        $this->setCalculatorColumnsForMetric($metric);
        return $this->utilization_calculator
                ->setStartDate($this->start_date)
                ->setEndDate(new \DateTime())
                ->calculate()
                ->getResult();
    }

}
