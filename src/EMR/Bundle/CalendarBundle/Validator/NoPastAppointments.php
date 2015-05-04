<?php

namespace EMR\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @Annotation
 */
class NoPastAppointments extends Constraint {

    public function validatedBy() {
        return 'no_past_appointments';
    }

    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}
