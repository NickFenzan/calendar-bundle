<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Description of AppointmentStatus
 * @ORM\Entity
 * @ORM\Table(name="calendar.appointment_status")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentStatus {
    /**
     * Appointment ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * Legacy ID
     * @var string
     * @ORM\Column(length=1, nullable=true)
     */
    protected $legacy_id;
    
    /**
     * Name of Status
     * @var string
     * @ORM\Column()
     */
    protected $name;
    
    /**
     * @var int
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $display_position;
    
    
    /**
     * Is the status a cancelled variety
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $cancelled;
    
    /**
     * Does the status trigger encounter auto-creation?
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $auto_create_encounter;
    
    public function getId() {
        return $this->id;
    }

    public function getLegacyId() {
        return $this->legacy_id;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getDisplayPosition() {
        return $this->display_position;
    }
    
    public function isCancelled() {
        return $this->cancelled;
    }
    
    public function isAutoCreateEncounter() {
        return $this->auto_create_encounter;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setLegacyId($legacy_id) {
        $this->legacy_id = $legacy_id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDisplayPosition($display_position) {
        $this->display_position = $display_position;
    }
    
    public function setCancelled($cancelled) {
        $this->cancelled = $cancelled;
    }
    
    public function setAutoCreateEncounter($auto_create_encounter) {
        $this->auto_create_encounter = $auto_create_encounter;
    }


}
