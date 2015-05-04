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

    public function __construct(DateTime $start, DateTime $end) {
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
