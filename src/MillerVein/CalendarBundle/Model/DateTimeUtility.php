<?php

namespace MillerVein\CalendarBundle\Model;

/**
 * Description of DateTimeUtility
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateTimeUtility {
    public static function moveTimeToDate(\DateTime $date, \DateTime $time){
        return new \DateTime($date->format('Y-m-d') . ' ' . $time->format('H:i:s'));
    }
}
