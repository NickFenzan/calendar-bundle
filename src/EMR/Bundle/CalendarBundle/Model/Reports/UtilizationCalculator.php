<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use EMR\Bundle\CalendarBundle\Model\Collections\ColumnCollection;

/**
 * Description of UtilizationCalculator
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationCalculator implements DateRangedCalendarCalculatorInterface {

    /**
     * @var UsedTimeCalculator
     */
    protected $used_time_calculator;

    /**
     * @var OpenTimeCalculator
     */
    protected $open_time_calculator;

    /**
     * @var DateTime
     */
    protected $start_date;

    /**
     * @var DateTime
     */
    protected $end_date;

    /**
     * @var ColumnCollection
     */
    protected $columns;
    
    /**
     * @var ArrayCollection
     */
    protected $tags;

    /**
     * Time Open in minutes
     * @var int
     */
    protected $open_time;
    
    /**
     * Time appointments fill in minutes
     * @var int
     */
    protected $used_time;
    
    /**
     * Right now the result is always computed in minutes
     * @var int
     */
    protected $result;

    public function __construct(UsedTimeCalculator $usedTimeCalculator, OpenTimeCalculator $openTimeCalculator) {
        $this->used_time_calculator = $usedTimeCalculator;
        $this->open_time_calculator = $openTimeCalculator;
        $this->columns = new ColumnCollection();
    }
    
    function getStartDate() {
        return $this->start_date;
    }

    function getEndDate() {
        return $this->end_date;
    }

    function getOpenTime() {
        return $this->open_time;
    }

    function getUsedTime() {
        return $this->used_time;
    }

    public function getResult() {
        return $this->result;
    }
    
    function getTags(){
        return $this->tags;
    }
    
    function setTags($tags) {
        $this->tags = $tags;
        $columns = new ColumnCollection();
        foreach($tags as $tag){
            foreach($tag->getColumns() as $column){
                $columns->add($column);
            }
        }
        $this->setColumns($columns);
    }
    
    function getColumns(){
        return $this->columns;
    }

    public function setColumns(ColumnCollection $columns) {
        foreach($columns as $column){
            $this->columns->add($column);
        }
        $this->used_time_calculator->setColumns($this->columns);
        $this->open_time_calculator->setColumns($this->columns);
        return $this;
    }

    public function setEndDate(DateTime $endDate) {
        $this->end_date = $endDate;
        $this->used_time_calculator->setEndDate($endDate);
        $this->open_time_calculator->setEndDate($endDate);
        return $this;
    }

    public function setStartDate(DateTime $startDate) {
        $this->start_date = $startDate;
        $this->used_time_calculator->setStartDate($startDate);
        $this->open_time_calculator->setStartDate($startDate);
        return $this;
    }

    public function calculate(){
        $this->open_time = $this->open_time_calculator->getResult();
        $this->used_time = $this->used_time_calculator->getResult();
        if(!$this->open_time){
            $this->result = null;
        }else{
            $this->result = round(($this->used_time / $this->open_time) * 100);
        }
    }
    
}
