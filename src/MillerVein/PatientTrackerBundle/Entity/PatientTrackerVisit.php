<?php

namespace MillerVein\PatientTrackerBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;
use MillerVein\CalendarBundle\Model\DateTimeUtility;

/**
 * Description of PatientTrackerVisit
 * @ORM\Entity(repositoryClass="PatientTrackerVisitRepository")
 * @ORM\Table(name="calendar.patient_tracker_visit")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientTrackerVisit {

    /**
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var PatientAppointment 
     * @ORM\OneToOne(targetEntity="MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment")
     */
    protected $appointment;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $checked_out = false;

    /**
     * @var ArrayCollection 
     * @ORM\OneToMany(targetEntity="PatientTrackerStep", mappedBy="visit", cascade={"persist", "remove"})
     * @ORM\OrderBy({"datetime" = "asc"})
     */
    protected $steps;

    public function __construct() {
        $this->steps = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getAppointment() {
        return $this->appointment;
    }

    function getChecked_out() {
        return $this->checked_out;
    }

    function getSteps() {
        return $this->steps;
    }

    function setAppointment(PatientAppointment $appointment) {
        $this->appointment = $appointment;
    }

    function setCheckedOut($checked_out) {
        $this->checked_out = (bool) $checked_out;
    }

    function setSteps(ArrayCollection $steps) {
        $this->steps = $steps;
    }

    function addStep(PatientTrackerStep $step) {
        $this->steps->add($step);
    }

    /**
     * @return PatientTrackerStep
     */
    function getCurrentStep(){
        return $this->steps->last();
    }
    
    function getTimeSinceLastStep() {
        $last = $this->steps->last()->getDateTime();
        $now = new \DateTime();
        return DateTimeUtility::differenceToString($last, $now);
    }
    
    function getTotalVisitTime() {
        /* @var $firstStep DateTime */
        /* @var $end DateTime */
        $firstStep = $this->steps->first()->getDateTime();
        $end = ($this->checked_out) ?
                $this->steps->last()->getDateTime() :
                $end = new DateTime();
        return DateTimeUtility::differenceToString($firstStep, $end);
    }
    
    

}
