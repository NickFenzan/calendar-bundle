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
        $conflicts = $this->em
                ->getRepository('MillerVeinCalendarBundle:Appointment\Appointment')
                ->findOverlappingAppointmentsByColumn($object->getColumn(), $object->getStart(), $object->getEnd(), [$object->getId()]);

        $overlapsAllowed = $object->getCategory()->getOverlapsAllowed();
        foreach($conflicts as $appointment){
            $appointmentOverlaps = $appointment->getCategory()->getOverlapsAllowed();
            $overlapsAllowed = ( $appointmentOverlaps > $overlapsAllowed ) ? $appointmentOverlaps : $overlapsAllowed;
        }
        if (count($conflicts) > $overlapsAllowed) {
            $this->context->addViolation('This timeslot is full for appointments of this type.');
        }
    }

}
