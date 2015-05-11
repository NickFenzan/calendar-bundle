<?php

namespace EMR\Bundle\CalendarBundle\Model;

use EMR\Bundle\CalendarBundle\Entity\Column;
use EMR\Bundle\CalendarBundle\Model\Collections\TimeSlotCollection;

/**
 * Description of TimeSlotCollectionFactory
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeSlotCollectionFactory {

    public static function addTimeSlots(TimeSlotCollection &$collection, Column $column, \DateTime $start, \DateTime $end, \DateInterval $min_interval, \DateInterval $interval, $readonly = false, $label = null) {
        $mins = 0;
        $min_interval_mins = $min_interval->format('%i');
        $interval_mins = $interval->format('%i');
        for ($time = clone $start; $time < $end; $time->add($min_interval)) {
            $timeslot = new TimeSlot($column, clone $time);
            
            if($mins == 0 || $mins % $interval_mins == 0){
                if ($label) {
                    $timeslot->setLabel($label);
                }
                $timeslot->setReadOnly($readonly);
            }else{
                $timeslot->setLabel('');
                $timeslot->setReadOnly(true);
            }
            $collection->add($timeslot);
            $mins += $min_interval_mins;
        }
    }

}
