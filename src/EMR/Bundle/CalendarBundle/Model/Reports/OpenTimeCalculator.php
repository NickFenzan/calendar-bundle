<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

use DateInterval;
use DateTime;
use EMR\Bundle\CalendarBundle\Model\Collections\ColumnCollection;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class OpenTimeCalculator implements DateRangedCalendarCalculatorInterface{

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
     * Right now the result is always computed in minutes
     * @var int
     */
    protected $result;

    public function __construct() {
        $this->columns = new ColumnCollection();
    }
    
    function getStartDate() {
        return $this->start_date;
    }

    function getEndDate() {
        return $this->end_date;
    }

    function getColumns() {
        return $this->columns;
    }

    function getResult() {
        $this->calculate();
        return $this->result;
    }

    function setStartDate(DateTime $start_date) {
        $this->start_date = $start_date;
    }

    function setEndDate(DateTime $end_date) {
        $this->end_date = $end_date;
    }

    function setColumns(ColumnCollection $columns) {
        $this->columns = $columns;
    }

    function setResult($result) {
        $this->result = $result;
    }

    public function calculate() {
        $timeOpen = 0;
        for ($date = clone $this->start_date; $date <= $this->end_date; $date->add(new DateInterval('P1D'))) {
            foreach ($this->columns as $column) {
                $hours = $column->findHours($date);
                if($hours){
                    $timeOpen += $hours->getTimeOpen();
                }
            }
        }
        $this->result = $timeOpen;
    }

}
