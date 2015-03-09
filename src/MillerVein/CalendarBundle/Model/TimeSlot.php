<?php
namespace MillerVein\CalendarBundle\Model;
/**
 * Description of TimeSlot
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeSlot {
    /**
     *
     * @var DateTime
     */
    protected $time;
    public function __construct(\DateTime $time) {
        $this->time = $time;
    }
    public function getTime() {
        return $this->time;
    }
}
