<?php

namespace EMR\Bundle\CalendarBundle\Model\Reports;

use DateTime;
use Doctrine\Common\Collections\Criteria;
use EMR\Bundle\CalendarBundle\Model\Collections\ColumnCollection;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UsedTimeCalculator implements DateRangedCalendarCalculatorInterface {

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
        $this->start_date = new \DateTime($start_date->format('Y-m-d') . ' 00:00:00');
    }

    function setEndDate(DateTime $end_date) {
        $this->end_date = new \DateTime($end_date->format('Y-m-d') . ' 23:59:59');
    }

    function setColumns(ColumnCollection $columns) {
        $this->columns = $columns;
    }

    function setResult($result) {
        $this->result = $result;
    }

    public function calculate() {
        $time = 0;
        foreach ($this->columns as $column) {
            $appts = $column->getAppointments();

            $criteria = Criteria::create()
                    ->where(
                    Criteria::expr()->andX(
                            Criteria::expr()->gte("start", $this->start_date), 
                            Criteria::expr()->lte("end", $this->end_date)
            ));
            
            $matchingAppts = $appts->matching($criteria);

            foreach ($matchingAppts as $appt) {
                if(!$appt->getStatus()->isCancelled()){
                    $time += $appt->getDuration();
                }
            }
        }
        $this->result = $time;
    }

}
