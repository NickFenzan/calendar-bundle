<?php

namespace EMR\Bundle\CalendarBundle\Request;

use Doctrine\Common\Collections\Collection;
use EMR\Bundle\CalendarBundle\Entity\Category\Category;
use EMR\Bundle\CalendarBundle\Entity\Column;
use MillerVein\Component\DateTime\DateTimeRange;
/**
 * Description of AppointmentMoverRequest
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentMoverRequest {
// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @var Collection|Column[]
     */
    protected $from_columns;

    /**
     * @var Column
     */
    protected $to_column;

    /**
     * @var DateTimeRange
     */
    protected $date_range;

    /**
     * @var Collection|Category[]
     */
    protected $categories; // </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Property Getter/Setter">
    function getFromColumns() {
        return $this->from_columns;
    }

    function getToColumn() {
        return $this->to_column;
    }

    function getDateRange() {
        return $this->date_range;
    }

    function getCategories() {
        return $this->categories;
    }

    function setFromColumns(Collection $from_columns) {
        $this->from_columns = $from_columns;
    }

    function setToColumn(Column $to_column) {
        $this->to_column = $to_column;
    }

    function setDateRange(DateTimeRange $date_range) {
        $this->date_range = $date_range;
    }

    function setCategories(Collection $categories) {
        $this->categories = $categories;
    }

// </editor-fold>

}
