<?php
namespace MillerVein\CalendarBundle\Model;

use DateTime;
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
        $rep = $this->getColumn()->getCalendar()->getAppointmentRepository();
        $appts = $rep->findAppointmentsByColumnDateTime($this->column->getColumn(), $this->getDateTime());
        foreach ($appts as $appt){
            $this->appointments[] = $appt;
            $apptDur = $appt->getDuration();
            $colInc = $this->column->getHours()->getSchedulingIncrement();
            $time = new DateTime($appt->getDateTime()->format('H:i'));
            for($i=$colInc;$i<$apptDur;$i+=$colInc){
                $time->add(new \DateInterval("PT{$colInc}M"));
                $overflowSlot = $this->column->getTimeSlot($time);
                if($overflowSlot){
                    $overflowSlot->setOverflowAppointment($appt);
                }
            }
        }
        return $this->appointments;
    }
    public function setOverflowAppointment(\MillerVein\CalendarBundle\Entity\Appointment $appt){
        $this->appointments[] = $appt;
    }
    
}
