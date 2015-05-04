<?php

namespace EMR\Bundle\CalendarBundle\Model\Collections;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use EMR\Bundle\CalendarBundle\Model\TimeSlot;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeSlotCollection extends ArrayCollection {

    const CLASS_NAME = '\EMR\Bundle\CalendarBundle\Model\TimeSlot';

    public function __construct(array $elements = array()) {
        foreach ($elements as $element) {
            $this->classCheck($element);
        }
        parent::__construct($elements);
    }

    /**
     * @return TimeSlot
     */
    public function get($key) {
        return parent::get($key);
    }

    public function add($value) {
        $this->classCheck($value);
        return parent::add($value);
    }

    protected function classCheck($element) {
        if (!is_a($element, static::CLASS_NAME)) {
            throw new Exception('Member of ' . get_called_class() . ' must be '
            . static::CLASS_NAME);
        }
    }
    
    public function applyAppointmentFragmentCollection(AppointmentFragmentCollection &$appointment_fragment_collection){
        foreach($appointment_fragment_collection as $key=>$fragment){
            /* @var $fragment \EMR\Bundle\CalendarBundle\Model\AppointmentFragment */
            foreach($this->toArray() as $timeslot){
                /* @var $timeslot \EMR\Bundle\CalendarBundle\Model\TimeSlot */
                if($timeslot->getDateTime() !== null && 
                        $timeslot->getDateTime() == $fragment->getDateTime() &&
                        $timeslot->getColumn()->getId() == $fragment->getAppointment()->getColumn()->getId()){
                    $timeslot->addAppointmentFragment($fragment);
                    $appointment_fragment_collection->remove($key);
                }
            }
        }
    }

}
