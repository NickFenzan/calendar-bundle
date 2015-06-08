<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoalReportResult {

    protected $name;
    protected $goal;
    protected $current;

    public function getName() {
        return $this->name;
    }

    public function getGoal() {
        return $this->goal;
    }

    public function getCurrent() {
        return $this->current;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setGoal($goal) {
        $this->goal = $goal;
        return $this;
    }

    public function setCurrent($current) {
        $this->current = $current;
        return $this;
    }

}
