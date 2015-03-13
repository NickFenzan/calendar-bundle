<?php
namespace MillerVein\CalendarBundle\Model;

use DateTime;
use MillerVein\CalendarBundle\Entity\Appointment\Appointment;
/**
 * Description of TimeSlot
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeSlot {
    /**
     * @var DateTime
     */
    protected $time;
    /**
     * @var CalendarColumn
     */
    protected $column;
    
    protected $appointments;
    
    public function __construct(DateTime $time, CalendarColumn $column) {
        $this->time = $time;
        $this->column = $column;
    }
    public function getTime() {
        return $this->time;
    }
    public function getDateTime(){
        $date = $this->getColumn()->getCalendar()->getDate();
        return new DateTime($date->format("Y-m-d") . " " . $this->time->format("H:i:s"));
    }
    public function getColumn() {
        return $this->column;
    }
    public function getAppointments() {
        return $this->appointments;
    }
    public function setAppointment(Appointment $appt){
        $this->appointments[] = $appt;
    }
    
}
