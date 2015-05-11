<?php

namespace EMR\Bundle\CalendarBundle\Model;

/**
 * Description of DateTimeUtility
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateTimeUtility {
    public static function moveTimeToDate(\DateTime $date, \DateTime $time){
        return new \DateTime($date->format('Y-m-d') . ' ' . $time->format('H:i:s'));
    }
    
    public static function differenceToString(\DateTime $date1, \DateTime $date2){
        $interval = $date1->diff($date2,true);
        return $interval->format('%H:%I:%S');
    }
}
