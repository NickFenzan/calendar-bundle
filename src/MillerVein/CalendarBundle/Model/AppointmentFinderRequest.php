<?php

namespace MillerVein\CalendarBundle\Model;

use DateTime;
use MillerVein\CalendarBundle\Entity\Category\PatientCategory;
use MillerVein\EMRBundle\Entity\Site;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFinderRequest {
    /**
     * @var PatientCategory
     */
    protected $category;
    /**
     * @var Site
     */
    protected $site;
    /**
     * @var DateTime
     */
    protected $min_date;
    /**
     * @var DateTime
     */
    protected $max_date;
    /**
     * @var DateTime
     */
    protected $min_time;
    /**
     * @var DateTime
     */
    protected $max_time;
    /**
     * @var int
     */
    protected $duration;
    /**
     * @var int
     */
    protected $day_of_week;
    
    public function getCategory() {
        return $this->category;
    }

    public function getSite() {
        return $this->site;
    }

    public function getMinDate() {
        return $this->min_date;
    }

    public function getMaxDate() {
        return $this->max_date;
    }
    
    public function getMinTime() {
        return $this->min_time;
    }

    public function getMaxTime() {
        return $this->max_time;
    }

    public function getDuration() {
        return $this->duration;
    }
    
    public function getDayOfWeek() {
        return $this->day_of_week;
    }

    
    public function setCategory(PatientCategory $category) {
        $this->category = $category;
    }

    public function setSite(Site $site) {
        $this->site = $site;
    }

    public function setMinDate(DateTime $min_date) {
        $this->min_date = $min_date;
    }

    public function setMaxDate(DateTime $max_date) {
        $this->max_date = $max_date;
    }
    
    public function setMinTime(DateTime $min_time) {
        $this->min_time = $min_time;
    }

    public function setMaxTime(DateTime $max_time) {
        $this->max_time = $max_time;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setDayOfWeek($day_of_week) {
        $this->day_of_week = $day_of_week;
    }

}
