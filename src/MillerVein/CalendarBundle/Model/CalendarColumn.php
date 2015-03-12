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
     * @var Calendar
     */
    protected $calendar;
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
     * @var Array
     */
    protected $appointments;
    
    /**
     * 
     * @param Column $column
     * @param Calendar $calendar
     */
    public function __construct(Calendar $calendar, Column $column) {
        $this->calendar = $calendar;
        $this->column = $column;
        $this->findHours();
        $this->buildTimeSlots();
        $this->buildAppointments();
    }
    
    protected function findHours(){
        foreach($this->column->getHours() as $hours){
            if($hours->doHoursApplyToDate($this->calendar->getDate())){
                $this->hours = $hours;
            }
        }
    }
    
    protected function buildTimeSlots(){
        if(null !== $this->hours){
            $this->time_slots = array();
            $hours = new HoursIterator($this->hours);
            foreach($hours as $time){
                $this->time_slots[] = new TimeSlot($time, $this);
            }
        }
    }
    
    protected function buildAppointments(){
        $rep = $this->getCalendar()->getAppointmentRepository();
        $appts = $rep->findAppointmentsByColumn($this->getColumn());
        foreach ($appts as $appt){
            //Strip the date
            $time = new DateTime($appt->getDateTime()->format('H:i'));
            //Get the Time Slot
            $timeSlot = $this->getTimeSlot($time);
            //Set this appointment on the timeslot
            $timeSlot->setAppointment($appt);
            //Look for overflow
            $apptDur = $appt->getDuration();
            $colInc = $this->getHours()->getSchedulingIncrement();
            
            for($i=$colInc;$i<$apptDur;$i+=$colInc){
                $time->add(new \DateInterval("PT{$colInc}M"));
                $overflowSlot = $this->getTimeSlot($time);
                if($overflowSlot){
                    $overflowSlot->setAppointment($appt);
                }
            }
        }
        return $this->appointments;
    }
    
    public function getCalendar() {
        return $this->calendar;
    }

    public function getColumn() {
        return $this->column;
    }

    public function getHours(){
        return $this->hours;
    }
    
    public function getTimeSlots(){
        return $this->time_slots;
    }
    
    public function getTimeSlot(DateTime $time){
        foreach($this->time_slots as $time_slot){
            if ($time_slot->getTime() == $time){
                return $time_slot;
            }
        }
        return null;
    }
}
