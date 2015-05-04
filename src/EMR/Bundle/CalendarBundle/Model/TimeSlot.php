<?php
namespace EMR\Bundle\CalendarBundle\Model;

use DateTime;
use EMR\Bundle\CalendarBundle\Entity\Column;
/**
 * Description of TimeSlot
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeSlot {
    /**
     * @var string
     */
    protected $label;
    /**
     * @var DateTime
     */
    protected $date_time;
    /**
     * @var Array
     */
    protected $appointments_fragments;
    /**
     * @var Column
     */
    protected $column;
    /**
     * @var bool
     */
    protected $read_only;
    
    public function __construct(Column $column, DateTime $date_time = null) {
        $this->column = $column;
        if($date_time){
            $this->date_time = $date_time;
            $this->label = $date_time->format('h:i');
        }
    }
    
    public function getLabel() {
        return $this->label;
    }
    
    public function getDateTime(){
        return $this->date_time;
    }
    
    public function getAppointmentFragments() {
        return $this->appointments_fragments;
    }
    
    public function getColumn(){
        return $this->column;
    }
    
    public function isReadOnly(){
        return $this->read_only;
    }
    
    function setLabel($label) {
        $this->label = $label;
    }

    function setDateTime(DateTime $date_time) {
        $this->date_time = $date_time;
    }

    public function setAppointmentFragments($appointment_fragments){
        $this->appointments_fragments = $appointment_fragments;
    }
    
    public function addAppointmentFragment($appointment_fragments){
        $this->appointments_fragments[] = $appointment_fragments;
    }
    
    public function setColumn(Column $column){
        $this->column = $column;
    }
    
    function setReadOnly($read_only) {
        $this->read_only = $read_only;
    }


}
