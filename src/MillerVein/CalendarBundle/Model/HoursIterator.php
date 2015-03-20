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

    public function __construct(Hours $hours) {
        $this->hours = $hours;
        $this->position = 0;
        $this->offset = new \DateInterval("PT0M");
    }

    public function current() {
        $openTime = clone $this->hours->getOpenTime();
        $currentTime = $openTime->add($this->offset);
        if($currentTime >= $this->hours->getLunchStart() &&
                $currentTime < $this->hours->getLunchEnd()){
            return "Lunch";
        }else{
            return $currentTime;
        }
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
        $mins = $this->hours->getSchedulingIncrement() * $this->position;
        $this->offset = new \DateInterval("PT{$mins}M");
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        $openTime = clone $this->hours->getOpenTime();
        return ($openTime->add($this->offset) < $this->hours->getCloseTime());
    }

}
