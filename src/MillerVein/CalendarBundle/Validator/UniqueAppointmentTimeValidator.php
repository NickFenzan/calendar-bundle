<?php

namespace MillerVein\CalendarBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;

/**
 * Description of UniqueAppointmentTimeValidator
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UniqueAppointmentTimeValidator extends ConstraintValidator {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint) {
        $object->calculateEndDateTime();
        $conflicts = $this->em
                ->getRepository('MillerVeinCalendarBundle:Appointment\Appointment')
                ->findOverlappingAppointmentsByColumn($object->getColumn(), $object->getStart(), $object->getEnd());

        if (count($conflicts) > 0) {
            $this->context->addViolationAt('start', 'There is already an event during this time!');
        }
    }

}
