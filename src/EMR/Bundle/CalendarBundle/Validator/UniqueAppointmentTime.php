<?php

namespace EMR\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Description of UniqueAppointmentTime
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @Annotation
 */
class UniqueAppointmentTime extends Constraint {

    public function validatedBy() {
        return 'unique_appointment_time';
    }

    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}
