<?php

namespace MillerVein\Bundle\CalendarBundle\Validator;

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
        //Temporary Hack to make Free consults non-blocking
        if($object->getCategory()->getId() == 17){
            return;
        }
        $conflicts = $this->em
                ->getRepository('MillerVeinCalendarBundle:Appointment\Appointment')
                ->findOverlappingAppointmentsByColumn($object->getColumn(), $object->getStart(), $object->getEnd(), [$object->getId()]);

        if (count($conflicts) > 0) {
            $this->context->addViolation('There is already an event during this time!');
        }
    }

}
