<?php

namespace MillerVein\CalendarBundle\Model\Reports\InvalidAppointment;

use MillerVein\CalendarBundle\Entity\Appointment\Appointment;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * Description of InvalidAppointmentResult
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class InvalidAppointmentResult {
    /**
     * @var Appointment 
     */
    protected $appointment;
    /**
     * @var ConstraintViolation 
     */
    protected $errors;
    public function __construct(Appointment $appointment, $errors) {
        $this->appointment = $appointment;
        $this->errors = $errors;
    }
    function getAppointment() {
        return $this->appointment;
    }

    function getErrors() {
        return $this->errors;
    }

}
