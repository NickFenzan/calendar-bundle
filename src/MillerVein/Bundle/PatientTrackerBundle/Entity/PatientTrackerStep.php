<?php

namespace MillerVein\Bundle\PatientTrackerBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use MillerVein\Bundle\PatientTrackerBundle\Entity\Room;

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
     * @var PatientTrackerVisit
     * @ORM\ManyToOne(targetEntity="PatientTrackerVisit", inversedBy="steps")
     */
    protected $visit;
    /**
     * @var Room
     * @ORM\ManyToOne(targetEntity="Room")
     */
    protected $room;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $datetime;
    
    public function __construct() {
        $this->datetime = new \DateTime();
    }
    
    function getId() {
        return $this->id;
    }

    function getRoom() {
        return $this->room;
    }
    
    function getVisit() {
        return $this->visit;
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
    
    function setVisit(PatientTrackerVisit $visit) {
        $this->visit = $visit;
    }

    function setDatetime(DateTime $datetime) {
        $this->datetime = $datetime;
    }

}
