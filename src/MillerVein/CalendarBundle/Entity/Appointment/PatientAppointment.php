<?php

namespace MillerVein\CalendarBundle\Entity\Appointment;

use Doctrine\ORM\Mapping as ORM;
use MillerVein\CalendarBundle\Entity\AppointmentStatus;
use MillerVein\EMRBundle\Entity\PatientData;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Patient
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity
 */
class PatientAppointment extends Appointment {

    /**
     * @var EMRPatient
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\PatientData")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="pid")
     * */
    protected $patient;

    public function getType() {
        return "patient";
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient(PatientData $patient) {
        $this->patient = $patient;
    }

}
