<?php

namespace MillerVein\CalendarBundle\Model;

use Iterator;
use MillerVein\CalendarBundle\Entity\Hours;

/**
 * Description of HoursIterator
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursIterator implements Iterator{
    protected $position;
    protected $hours;
    
    public function __construct(Hours $hours) {
        $this->hours = $hours;
        $this->rewind();
    }
    
    public function current() {
        
        
        $fromOpen = $this->hours->getOpenTime()->add($interval);
        if($fromOpen < $this->hours->getLunchStart()){
            return $this->hours->getOpenTime()->add($interval);
        }
        
        $fromLunch = $this->hours->getLunchEnd()->add($interval);
        if($fromLunch < $this->hours->getCloseTime()){
            return $this->hours->getOpenTime()->add($interval);
        }
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        
    }
    
    public function getInterval(){
        $increment = $this->hours->getSchedulingIncrement();
        return new \DateInterval("PT{$increment}M");
    }
    
    public function getLunchInterval(){
        $lunchDiff = $this->hours->getLunchStart()->diff($this->hours->getLunchEnd(), true);
        
        
    }
    
}
