<?php

namespace EMR\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class NoPastAppointmentsValidator extends ConstraintValidator {
    public function validate($object, Constraint $constraint) {
        $limit = new \DateTime();
        $limit->sub(new \DateInterval('P1D'));
        if($object->getStart() < $limit){
            $this->context->addViolation('Appointments that started more than '
                    . '24 hours ago are not editable.');
        }
    }
}