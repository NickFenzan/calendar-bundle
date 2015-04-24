<?php

namespace MillerVein\CalendarBundle\Model\Collections;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\AppointmentFragment;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFragmentCollection extends ArrayCollection {

    const CLASS_NAME = '\MillerVein\CalendarBundle\Model\AppointmentFragment';

    public function __construct(array $elements = array()) {
        foreach ($elements as $element) {
            $this->classCheck($element);
        }
        parent::__construct($elements);
    }

    /**
     * @return AppointmentFragment
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
    
    public function earliestTime(){
        $earliestTime = null;
        
        foreach($this->toArray() as $element){
            $fragmentTime = new DateTime($element->getDateTime()->format('H:i'));
            if($earliestTime === null || $fragmentTime < $earliestTime){
                $earliestTime = $fragmentTime;
            }
        }
        return $earliestTime;
    }
    public function latestTime(){
        $latestTime = null;
        foreach($this->toArray() as $element){
            $fragmentTime = new DateTime($element->getDateTime()->format('H:i'));
            if($latestTime === null || $fragmentTime > $latestTime){
                $latestTime = $fragmentTime;
            }
        }
        return $latestTime;
    }

    public function hasColumn(Column $column){
        foreach($this->toArray() as $element){
            if($column->getId() == $element->getAppointment()->getColumn()->getId()){
                return true;
            }
        }
        return false;
    }

    public function merge(AppointmentFragmentCollection $collection){
        foreach($collection as $entry){
            $this->add($entry);
        }
    }
}
