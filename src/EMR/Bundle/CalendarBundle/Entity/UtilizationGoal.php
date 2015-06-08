<?php

namespace EMR\Bundle\CalendarBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EMR\Bundle\CalendarBundle\Entity\Repository\UtilizationGoalRepository")
 * @ORM\Table(name="calendar_utilization_goal")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoal {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @var DateTime
     */
    protected $start_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var DateTime
     */
    protected $end_date;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $goal;

    /**
     * @ORM\ManyToOne(targetEntity="UtilizationMetric", inversedBy="goals")
     * @var UtilizationMetric
     */
    protected $metric;

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getId() {
        return $this->id;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getGoal() {
        return $this->goal;
    }

    public function getMetric() {
        return $this->metric;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setStartDate(DateTime $start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function setEndDate(DateTime $end_date = null) {
        $this->end_date = $end_date;
        return $this;
    }

    public function setGoal($goal) {
        $this->goal = $goal;
        return $this;
    }

    public function setMetric(UtilizationMetric $metric) {
        $this->metric = $metric;
        return $this;
    }

// </editor-fold>
}
