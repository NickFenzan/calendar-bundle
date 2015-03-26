<?php

namespace MillerVein\CalendarBundle\Entity\Appointment;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\AppointmentRepository;
use MillerVein\CalendarBundle\Entity\AppointmentStatus;
use MillerVein\CalendarBundle\Entity\Category\Category;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Validator\UniqueAppointmentTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Appointment
 *
 * @ORM\Entity(repositoryClass="AppointmentRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="calendar.appointment",indexes={@ORM\Index(name="date_index", columns={"start"})})
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"patient" = "PatientAppointment", "provider" = "ProviderAppointment"})
 * @UniqueAppointmentTime()
 * @author Nick Fenzan <nickf@millervein.com>
 */
abstract class Appointment {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * Appointment ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * DateTime
     * @var DateTime 
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime")
     */
    protected $start;

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
     * DateTime
     * @var DateTime 
     * @ORM\Column(type="datetime")
     */
    protected $end;

    /**
     * @ORM\Column(nullable=true)
     * @var string
     */
    protected $notes;

    /**
     * Column Appointment is associated with
     * @ORM\ManyToOne(targetEntity="MillerVein\CalendarBundle\Entity\Column")
     * @Assert\NotBlank()
     * @var Column
     */
    protected $column;

    /**
     * Category Appointment is associated with
     * @ORM\ManyToOne(targetEntity="MillerVein\CalendarBundle\Entity\Category\Category")
     * @Assert\NotBlank()
     * @var Category
     */
    protected $category;

    /**
     * Appointment Status
     * @ORM\ManyToOne(targetEntity="MillerVein\CalendarBundle\Entity\AppointmentStatus")
     * @Assert\NotBlank()
     * @var AppointmentStatus
     */
    protected $status;

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getId() {
        return $this->id;
    }

    public function getStart() {
        return $this->start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getNotes() {
        return $this->notes;
    }

    public function getColumn() {
        return $this->column;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getStatus() {
        return $this->status;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setStart(DateTime $date_time) {
        $this->start = $date_time;
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function setColumn(Column $column) {
        $this->column = $column;
    }

    public function setCategory(Category $category) {
        $this->category = $category;
    }

    public function setStatus(AppointmentStatus $status) {
        $this->status = $status;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function calculateEndDateTime() {
        $endDate = clone $this->start;
        $endDate->add(new \DateInterval('PT' . $this->duration . 'M'));
        $this->end = $endDate;
    }

// </editor-fold>
}
