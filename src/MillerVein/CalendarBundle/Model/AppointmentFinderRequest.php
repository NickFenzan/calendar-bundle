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
     * @var int
     */
    protected $duration;
    
    public function __construct(PatientCategory $category, Site $site, $min_date, $max_date, $duration) {
        $this->category = $category;
        $this->site = $site;
        $this->min_date = $min_date;
        $this->max_date = $max_date;
        $this->duration = $duration;
    }
    
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

    public function getDuration() {
        return $this->duration;
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

    public function setDuration($duration) {
        $this->duration = $duration;
    }


}
