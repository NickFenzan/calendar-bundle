<?php

namespace MillerVein\CalendarBundle\Model;

use MillerVein\CalendarBundle\Entity\Appointment\Appointment;

/**
 * Description of DisplayAppointmentFragment
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DisplayAppointmentFragment {
    protected $appointment;
    protected $time;
    protected $isFirst = false;
    protected $isLast = false;
    
    public function __construct(Appointment $appointment, \DateTime $time, $isFirst=false, $isLast=false) {
        $this->appointment = $appointment;
        $this->time = $time;
        $this->isFirst = $isFirst;
        $this->isLast = $isLast;
    }
    
    public function getAppointment() {
        return $this->appointment;
    }

    public function getTime() {
        return $this->time;
    }

    public function isFirst() {
        return $this->isFirst;
    }

    public function isLast() {
        return $this->isLast;
    }

    public function setAppointment(Appointment $appointment) {
        $this->appointment = $appointment;
    }
    
    public function setTime(\DateTime $time) {
        $this->time = $time;
    }

    public function setFirst($isFirst) {
        $this->isFirst = (bool) $isFirst;
    }

    public function setLast($isLast) {
        $this->isLast = (bool) $isLast;
    }


}
