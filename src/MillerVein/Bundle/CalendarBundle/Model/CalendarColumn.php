<?php

namespace MillerVein\Bundle\CalendarBundle\Model;

use DateTime;
use MillerVein\Bundle\CalendarBundle\Entity\Column;
use MillerVein\Bundle\CalendarBundle\Entity\Hours;

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
     * @var bool
     */
    protected $show_cancelled;

    /**
     *
     * @var Array
     */
    protected $appointment_bank;

    /**
     * 
     * @param Column $column
     * @param Calendar $calendar
     */
    public function __construct(Calendar $calendar, Column $column, $showCancelled = false) {
        $this->show_cancelled = $showCancelled;
        $this->calendar = $calendar;
        $this->column = $column;
        $this->findHours();
        if (null !== $this->hours) {
            $this->buildTimeSlots();
            $this->buildAppointmentBank();
            $this->fillInAppointments();
        }
    }

    protected function findHours() {
        foreach ($this->column->getHours() as $hours) {
            if ($hours->doHoursApplyToDate($this->calendar->getDate())) {
                $this->hours = $hours;
                break;
            }
        }
    }
    
    protected function buildAppointmentBank(){
        $this->appointment_bank = new ColumnAppointmentBank($this->calendar->getAppointmentRepository(), $this, $this->show_cancelled);
    }
    
    protected function fillInAppointments(){
        $bank = $this->appointment_bank;
        $appts = $bank->getAppointments();
        if($appts){
            foreach($appts as $appt){
                foreach($appt->getFragments() as $fragment){
                    $timeSlot = $this->getTimeSlot($fragment->getTime());
                    if($timeSlot){
                        $appt->setDisplayed(true);
                        $timeSlot->setAppointment($fragment);
                    }
                }
            }
        }
    }

    protected function buildTimeSlots() {
        $this->time_slots = array();
        $hours = new HoursIterator($this->hours);
        foreach ($hours as $time) {
            if(is_a($time, "DateTime")){
                $this->time_slots[] = new TimeSlot($time, $this);
            }else{
                $this->time_slots[] = "lunch";
            }
        }
    }

    public function getCalendar() {
        return $this->calendar;
    }

    public function getColumn() {
        return $this->column;
    }

    public function getHours() {
        return $this->hours;
    }

    public function getTimeSlots() {
        return $this->time_slots;
    }

    /**
     * 
     * @param DateTime $time
     * @return TimeSlot|null
     */
    public function getTimeSlot(DateTime $time) {
        foreach ($this->time_slots as $time_slot) {
            if (is_a($time_slot,'MillerVein\Bundle\CalendarBundle\Model\TimeSlot') && $time_slot->getTime() == $time) {
                return $time_slot;
            }
        }
        return null;
    }

}
