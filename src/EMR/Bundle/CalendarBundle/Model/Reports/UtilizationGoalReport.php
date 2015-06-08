<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use EMR\Bundle\CalendarBundle\Entity\Repository\UtilizationGoalRepository;
use EMR\Bundle\CalendarBundle\Entity\Repository\UtilizationMetricRepository;
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

    public function __construct(UtilizationMetricRepository $utilizationMetricRepo, UtilizationGoalRepository $utilizationGoalRepo) {
        $this->utilization_metric_repo = $utilizationMetricRepo;
        $this->utilization_goal_repo = $utilizationGoalRepo;
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
        $goal = $this->utilization_goal_repo->findOneBy([]);
        echo "Goal: " . $goal->getId();
        $spec = new \EMR\Bundle\CalendarBundle\Specification\FilterGoals($goal);
        $metrics = $this->utilization_metric_repo->match($spec);
//        $qb = $this->utilization_metric_repo->createQueryBuilder('m');
//        $qb->join('m.goals', 'g');
//        $qb->where($qb->expr()->eq('g.id', $goal->getId()));
//        $query = $qb->getQuery();
//        $metrics = $query->getResult();
        
        foreach($metrics as $metric){
            echo $metric->getName();
        }
        
        if (!isset($this->start_date) || !isset($this->end_date)) {
            throw new Exception("Start and end date must be set to run the report.");
        }
        $this->findMetrics();
        $this->findActiveGoals();
        foreach($this->metrics as $metric){
            $built = new UtilizationGoalReportMetric();
            $built->setName($metric->getName());
            $this->results[] = $built;
        }
    }

    protected function findMetrics() {
        $this->metrics = $this->utilization_metric_repo->findAll();
    }

    protected function findActiveGoals() {
        
    }

}
