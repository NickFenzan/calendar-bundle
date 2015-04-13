<?php

namespace MillerVein\CalendarBundle\Model;

use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\Collections\TimeSlotCollection;

/**
 * Description of TimeSlotCollectionFactory
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeSlotCollectionFactory {
    public static function addTimeSlots(TimeSlotCollection &$collection, Column $column, \DateTime $start, \DateTime $end, $interval, $readonly = false, $label = null) {
        for ($time = clone $start; $time < $end; $time->add($interval)) {
            $timeslot = new TimeSlot($column, clone $time);
            $timeslot->setReadOnly($readonly);
            if($label){
                $timeslot->setLabel($label);
            }
            $collection->add($timeslot);
        }
    }
}
