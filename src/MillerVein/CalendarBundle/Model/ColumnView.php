<?php

namespace MillerVein\CalendarBundle\Model;

use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\Collections\TimeSlotCollection;

/**
 * Description of ColumnDayView
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnView {
    /**
     * @var string
     */
    protected $label;
    /**
     * @var Column
     */
    protected $column;
    /**
     * @var TimeSlotCollection
     */
    protected $time_slot_collection;
    
    public function __construct(Column $column) {
        $this->column = $column;
        $this->label = $this->column->getName();
    }
    
    public function getLabel(){
        return $this->label;
    }
    
    public function setLabel($label){
        $this->label = $label;
    }
    
    public function setTimeSlotCollection(TimeSlotCollection $time_slot_collection) {
        $this->time_slot_collection = $time_slot_collection;
    }
    
    public function getTimeslots(){
        return $this->time_slot_collection;
    }

    
    
}
