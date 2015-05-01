<?php

namespace MillerVein\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @Annotation
 */
class HoursAppointmentTime extends Constraint {

    public function validatedBy() {
        return 'valid_hours_appointment_time';
    }

    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}
