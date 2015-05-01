<?php

namespace MillerVein\Bundle\CalendarBundle\Model;

use MillerVein\Bundle\CalendarBundle\Entity\Column;
use MillerVein\Bundle\CalendarBundle\Entity\Hours;
use MillerVein\Bundle\CalendarBundle\Model\Collections\TimeSlotCollection;

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
     * @var Column
     */
    protected $hours;
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
    
    public function getHours(){
        return $this->hours;
    }
    
    public function setHours(Hours $hours = null){
        $this->hours = $hours;
    }
    
    public function setTimeSlotCollection(TimeSlotCollection $time_slot_collection) {
        $this->time_slot_collection = $time_slot_collection;
    }
    
    public function getTimeslots(){
        return $this->time_slot_collection;
    }

    
    
}
