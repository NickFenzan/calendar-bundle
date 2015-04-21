<?php

namespace MillerVein\PatientTrackerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;

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
     * @ORM\OneToOne(targetEntity="\MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment")
     */
    protected $appointment;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $checked_out = false;
    /**
     * @var ArrayCollection 
     * @ORM\OneToMany(targetEntity="\MillerVein\PatientTrackerBundle\Entity\PatientTrackerStep", mappedBy="visit", cascade={"persist", "remove"})
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
    
    function addStep(PatientTrackerStep $step){
        $this->steps->add($step);
    }

}
