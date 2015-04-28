<?php

namespace MillerVein\CalendarBundle\Model\Reports\InvalidAppointment;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use MillerVein\EMRBundle\Entity\Site;

/**
 * Description of InvalidAppointments
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class InvalidAppointmentRequest {
    /**
     * @var DateTime
     */
    protected $start_date;
    /**
     * @var DateTime
     */
    protected $end_date;
    /**
     * @var bool
     */
    protected $outside_of_hours = true;
    /**
     * @var bool
     */
    protected $overlapping_appointments = true;
    /**
     * @var ArrayCollection
     */
    protected $sites;
    
    public function __construct() {
        $this->sites = new ArrayCollection();
    }
    
    function getStartDate() {
        return $this->start_date;
    }

    function getEndDate() {
        return $this->end_date;
    }

    function getOutsideOfHours() {
        return $this->outside_of_hours;
    }

    function getOverlappingAppointments() {
        return $this->overlapping_appointments;
    }

    function getSites() {
        return $this->sites;
    }

    function setStartDate(DateTime $start_date) {
        $this->start_date = $start_date;
    }

    function setEndDate(DateTime $end_date) {
        $this->end_date = $end_date;
    }

    function setOutsideOfHours($outside_of_hours) {
        $this->outside_of_hours = $outside_of_hours;
    }

    function setOverlappingAppointments($overlapping_appointments) {
        $this->overlapping_appointments = $overlapping_appointments;
    }

    function setSites(ArrayCollection $sites) {
        $this->sites = $sites;
    }


}