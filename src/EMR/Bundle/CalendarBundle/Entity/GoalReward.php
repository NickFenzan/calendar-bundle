<?php

namespace EMR\Bundle\CalendarBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EMR\Bundle\CalendarBundle\Entity\Repository\GoalRewardRepository")
 * @ORM\Table(name="calendar_goal_reward")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class GoalReward {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * What the reward is
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * A brief description of the reward
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * The date this reward incentive starts
     * @ORM\Column(type="date")
     * @var DateTime
     */
    protected $start_date;

    /**
     * The date this reward incentive ends. NULL represents current.
     * @ORM\Column(type="date", nullable=true)
     * @var DateTime
     */
    protected $end_date;

    /**
     * The amount of goals that must be met to earn the reward.
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $goal_threshold; // </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Getters">

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getStartDate() {
        return $this->start_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }

    public function getGoalThreshold() {
        return $this->goal_threshold;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setStartDate(DateTime $start_date) {
        $this->start_date = $start_date;
        return $this;
    }

    public function setEndDate(DateTime $end_date = null) {
        $this->end_date = $end_date;
        return $this;
    }

    public function setGoalThreshold($goal_threshold) {
        $this->goal_threshold = $goal_threshold;
        return $this;
    }

// </editor-fold>
}
