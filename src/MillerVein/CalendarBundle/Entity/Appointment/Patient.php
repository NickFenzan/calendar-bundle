<?php

namespace MillerVein\CalendarBundle\Entity\Appointment;

use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\Patient as EMRPatient;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Patient
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity
 */
class Patient extends Appointment{
    /**
     * @var EMRPatient
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="MillerVein\CalendarBundle\Entity\Patient")
     **/
    protected $patient;
    
    public function getType() {
        return "patient";
    }
    
    public function getPatient() {
        return $this->patient;
    }

    public function setPatient(EMRPatient $patient) {
        $this->patient = $patient;
    }

}
