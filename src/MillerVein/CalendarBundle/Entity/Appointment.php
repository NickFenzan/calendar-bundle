<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Appointment
 *
 * @ORM\Entity(repositoryClass="MillerVein\CalendarBundle\Entity\AppointmentRepository")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Appointment {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * Appointment ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Appointment Title
     * @var string
     * @Assert\NotBlank() 
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * DateTime
     * @var DateTime 
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    protected $date_time;

    /**
     * Duration in Minutes
     * @var int
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min=5,
     *      max=240
     * )
     */
    protected $duration; 
    
    /**
     * Column Appointment is associated with
     * @ORM\ManyToOne(targetEntity="Column")
     * @Assert\NotBlank()
     * @var MillerVein\CalendarBundle\Entity\Column
     */
    protected $column;
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Getters">

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDateTime() {
        return $this->date_time;
    }

    public function getDuration() {
        return $this->duration;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDateTime(DateTime $date_time) {
        $this->date_time = $date_time;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }
// </editor-fold>


}
