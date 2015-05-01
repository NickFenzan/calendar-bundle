<?php

namespace MillerVein\Bundle\CalendarBundle\Model;

use DateInterval;
use DateTime;
use MillerVein\Bundle\CalendarBundle\Entity\Appointment\Appointment;

/**
 * Description of DisplayAppointment
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DisplayAppointment {

    protected $appointment;
    protected $increment;
    protected $displayed = false;
    protected $fragments;

    public function __construct(Appointment $appointment, $schedulingIncrement) {
        $this->appointment = $appointment;
        $this->increment = $schedulingIncrement;
        $this->buildFragments();
    }

    protected function buildFragments() {
        //Strip the date
        $workingTime = new DateTime($this->appointment->getStart()->format('H:i'));
        $this->fragments[] = new DisplayAppointmentFragment($this->appointment, clone $workingTime, true);

        for ($i = $this->increment; $i < $this->appointment->getDuration(); $i += $this->increment) {
            $workingTime->add(new DateInterval("PT{$this->increment}M"));
            $this->fragments[] = new DisplayAppointmentFragment($this->appointment, clone $workingTime);
        }
        
        end($this->fragments);
        $lastKey = key($this->fragments);
        reset($this->fragments);
        
        $this->fragments[$lastKey]->setLast(true);
    }
    
    public function getFragments() {
        return $this->fragments;
    }

    public function getAppointment() {
        return $this->appointment;
    }
    
    public function getIncrement() {
        return $this->increment;
    }

    public function getDisplayed() {
        return $this->displayed;
    }

    public function setDisplayed($displayed) {
        $this->displayed = $displayed;
    }



}
