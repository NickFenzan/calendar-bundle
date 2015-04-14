<?php

namespace MillerVein\CalendarBundle\Entity\Appointment;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\AppointmentStatus;
use MillerVein\CalendarBundle\Entity\Category\Category;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Validator as MVAssert;
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
 * @MVAssert\UniqueAppointmentTime(groups={"new"})
 * @MVAssert\HoursAppointmentTime(groups={"new"})
 * @MVAssert\CategoryColumn(groups={"new"})
 * @MVAssert\NoPastAppointments()
 * @author Nick Fenzan <nickf@millervein.com>
 */
abstract class Appointment {
    
    const TYPE_PATIENT = 'patient';
    const TYPE_PROVIDER = 'provider';

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
     * @*Assert\Range(
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
    
    abstract function getType();

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
        $this->calculateEndDateTime();
    }

    public function setNotes($notes) {
        $this->notes = $notes;
    }

    public function setDuration($duration) {
        $this->duration = $duration;
        $this->calculateEndDateTime();
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

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Lifecycle Callbacks">
    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
//        $this->legacyInsert();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
//        $this->legacyUpdate();
    }


    /**
     * @ORM\PreRemove
     */
    public function preRemove() {
//        $this->legacyDelete();
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Calculated Properties">
    protected function calculateEndDateTime() {
        if($this->start !== null && $this->duration !== null){
            $endDate = clone $this->start;
            $endDate->add(new \DateInterval('PT' . $this->duration . 'M'));
            $this->end = $endDate;
        }
    }
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Legacy Database Functions">
    //Legacy Statics
    const DefaultRecur = 'a:6:{s:17:"event_repeat_freq";N;s:22:"event_repeat_freq_type";N;s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";s:6:"exdate";N;}';
    const DefaultLocation = 'a:6:{s:14:"event_location";s:0:"";s:13:"event_street1";s:0:"";s:13:"event_street2";s:0:"";s:10:"event_city";s:0:"";s:11:"event_state";s:0:"";s:12:"event_postal";s:0:"";}';
    /**
     * @return \PDO
     */
    protected function sqlConnect(){
        $pdo = new \PDO('mysql:host=localhost;dbname=openemr', 'openemr', 'escargot');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    
    protected function legacyInsert(){
        
    }
    
    protected function legacyUpdate(){
        
    }
    
    protected function legacyDelete() {
        $statement = "DELETE FROM openemr_postcalendar_events "
                . " WHERE  pc_eid = :id ";
        $pdo = $this->sqlConnect();
        try {
            $statement = $pdo->prepare($statement);
            $statement->bindValue(':id', $this->id);
            $statement->execute();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            die();
        }
    }
// </editor-fold>

}
