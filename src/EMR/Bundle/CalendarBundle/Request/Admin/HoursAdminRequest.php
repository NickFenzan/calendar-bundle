<?php

namespace EMR\Bundle\CalendarBundle\Request\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use MillerVein\Component\DateTime\DateTimeRange;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursAdminRequest {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @var ArrayCollection
     */
    protected $columns;

    /**
     * @var DateTimeRange
     */
    protected $start_date;

    /**
     * @var DateTimeRange
     */
    protected $end_date;

    /**
     * @var DateTimeRange
     */
    protected $open_time;

    /**
     * @var DateTimeRange
     */
    protected $lunch_start;

    /**
     * @var DateTimeRange
     */
    protected $lunch_end;

    /**
     * @var DateTimeRange
     */
    protected $close_time; // </editor-fold>

    public function __construct() {
        $this->columns = new ArrayCollection();
    }

    function getColumns() {
        return $this->columns;
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

    function getLunchStart() {
        return $this->lunch_start;
    }

    function getLunchEnd() {
        return $this->lunch_end;
    }

    function getCloseTime() {
        return $this->close_time;
    }

    function setColumns(ArrayCollection $columns) {
        $this->columns = $columns;
    }

    function setStartDate(DateTimeRange $start_date = null) {
        $this->start_date = $start_date;
    }

    function setEndDate(DateTimeRange $end_date = null) {
        $this->end_date = $end_date;
    }

    function setOpenTime(DateTimeRange $open_time = null) {
        $this->open_time = $open_time;
    }

    function setLunchStart(DateTimeRange $lunch_start = null) {
        $this->lunch_start = $lunch_start;
    }

    function setLunchEnd(DateTimeRange $lunch_end = null) {
        $this->lunch_end = $lunch_end;
    }

    function setCloseTime(DateTimeRange $close_time = null) {
        $this->close_time = $close_time;
    }

}
