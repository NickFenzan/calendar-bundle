<?php

namespace MillerVein\Component\DateTime;

use DateTime;

/**
 * Description of DateTimeRange
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateTimeRange {

    /**
     * @var DateTime
     */
    protected $start;

    /**
     * @var DateTime
     */
    protected $end;

    public function __construct(DateTime $start = null, DateTime $end = null) {
        if($start === null){
            $start = new \DateTime('0000-00-00 00:00:00');
        }
        if($end === null){
            $end = new \DateTime('9999-12-31 23:59:59');
        }
        $this->start = $start;
        $this->end = $end;
    }

    function getStart() {
        return $this->start;
    }

    function getEnd() {
        return $this->end;
    }

    function setStart(DateTime $start) {
        $this->start = $start;
    }

    function setEnd(DateTime $end) {
        $this->end = $end;
    }

}
