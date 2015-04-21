<?php

namespace MillerVein\PatientTrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;
use MillerVein\PatientTrackerBundle\Entity\Room;

/**
 * Description of PatientTrackerStep
 * @ORM\Entity(repositoryClass="PatientTrackerStepRepository")
 * @ORM\Table(name="calendar.patient_tracker_step")
 * @author Nick Fenzan <nickf@millervein.com>
 * 
 */
class PatientTrackerStep {
    /**
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @var Room
     * @ORM\ManyToOne(targetEntity="\MillerVein\PatientTrackerBundle\Entity\PatientTrackerVisit", inversedBy="steps")
     */
    protected $visit;
    /**
     * @var Room
     * @ORM\ManyToOne(targetEntity="\MillerVein\PatientTrackerBundle\Entity\Room")
     */
    protected $room;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    protected $datetime;
    
    function getId() {
        return $this->id;
    }

    function getRoom() {
        return $this->room;
    }

    function getDatetime() {
        return $this->datetime;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setRoom(Room $room) {
        $this->room = $room;
    }

    function setDatetime(\DateTime $datetime) {
        $this->datetime = $datetime;
    }

}
