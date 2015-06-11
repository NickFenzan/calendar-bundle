<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoalReportResult {

    /**
     * The name of the goal
     * @var string
     */
    protected $name;

    /**
     * The percentage of the schedule that was utilized to date
     * @var int
     */
    protected $current;

    /**
     * The percentage of the schedule that is utilized through the end of the month
     * @var int
     */
    protected $projected;

    /**
     * The percentage of the schedule that we want utilized
     * @var int
     */
    protected $goal;

    public function getName() {
        return $this->name;
    }

    public function getCurrent() {
        return $this->current;
    }

    public function getProjected() {
        return $this->projected;
    }

    public function getGoal() {
        return $this->goal;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setCurrent($current) {
        $this->current = $current;
        return $this;
    }

    public function setProjected($projected) {
        $this->projected = $projected;
        return $this;
    }

    public function setGoal($goal) {
        $this->goal = $goal;
        return $this;
    }
    
    public function getValuesAsArray(){
        return [
            'current' => $this->current,
//            'projected' => $this->projected,
            'goal' => $this->goal,
        ];
    }
    
    public function getProgressBarParts(){
        $values = $this->getValuesAsArray();
        asort($values);
        $parts = array();
        $currentValue = 0;
        foreach($values as $name=>$value){
            if($value > $currentValue){
                $part = array();
                $part['barClass'] = $name;
                $part['text'] = true;
                $part['value'] = $value - $currentValue;
                $currentValue = $value;
                $parts[] = $part;
            }
        }
        
        return json_encode($parts);
    }

}
