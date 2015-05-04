<?php

namespace EMR\Bundle\CalendarBundle\Model;

use EMR\Bundle\CalendarBundle\Entity\Column;
use EMR\Bundle\CalendarBundle\Model\Collections\ColumnCollection;
use EMR\Bundle\CalendarBundle\Model\Collections\ColumnViewCollection;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Calendar {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * Columns calendar is to display
     * @var ColumnViewCollection
     */
    protected $columns;
// </editor-fold>
    public function __construct() {
        $this->columns = new ColumnViewCollection();
    }
    
    function getColumns() {
        return $this->columns;
    }

    function setColumns(ColumnViewCollection $columns) {
        $this->columns = $columns;
    }
    function addColumn(ColumnView $column){
        $this->columns->add($column);
    }
}
