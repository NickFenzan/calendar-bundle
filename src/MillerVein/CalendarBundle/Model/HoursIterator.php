<?php

namespace MillerVein\CalendarBundle\Model;

use Iterator;
use MillerVein\CalendarBundle\Entity\Hours;

/**
 * Description of HoursIterator
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursIterator implements Iterator {

    protected $position;
    protected $hours;
    protected $offset;
    protected $lunch = false;

    public function __construct(Hours $hours) {
        $this->hours = $hours;
        $this->position = 0;
        $this->offset = new \DateInterval("PT0M");
    }

    public function current() {
        $openTime = clone $this->hours->getOpenTime();
        return $openTime->add($this->offset);
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
        $mins = $this->hours->getSchedulingIncrement() * $this->position;
        $offset = new \DateInterval("PT{$mins}M");
        $openTime = clone $this->hours->getOpenTime();
        if($openTime->add($offset) < $this->hours->getLunchStart()){
            $this->offset = $offset;
        }else{
            $lunchMins = ($this->hours->getLunchEnd()->getTimestamp() -
            $this->hours->getLunchStart()->getTimestamp()) / 60;
            $adjusted = $mins + $lunchMins;
            $this->offset = new \DateInterval("PT{$adjusted}M");
        }
        
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        $openTime = clone $this->hours->getOpenTime();
        return ($openTime->add($this->offset) < $this->hours->getCloseTime());
    }

}
