<?php

namespace MillerVein\CalendarBundle\Model;

use DateTime;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Entity\Hours;

/**
 * Description of CalendarColumn
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CalendarColumn {
    /**
     *
     * @var DateTime
     */
    protected $date;
    /**
     *
     * @var Column
     */
    protected $column;
    /**
     * @var Hours
     */
    protected $hours = null;
    /**
     * @var Array
     */
    protected $time_slots = null;
    
    /**
     * 
     * @param Column $column
     * @param DateTime $date
     */
    public function __construct(Column $column, DateTime $date) {
        $this->date = $date;
        $this->column = $column;
        $this->findHours();
        $this->buildTimeSlots();
    }
    
    protected function findHours(){
        foreach($this->column->getHours() as $hours){
            if($hours->doHoursApplyToDate($this->date)){
                $this->hours = $hours;
            }
        }
    }
    
    protected function buildTimeSlots(){
        if(null !== $this->hours){
            
        }
    }
    
    public function getDate() {
        return $this->date;
    }

    public function getColumn() {
        return $this->column;
    }

    public function getHours(){
        return $this->hours;
    }
    
    public function getTimeSlots(){
        
    }
    
}
