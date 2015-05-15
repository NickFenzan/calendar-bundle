<?php

namespace EMR\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursAppointmentTimeValidator extends ConstraintValidator {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint) {
        /* @var $object \EMR\Bundle\CalendarBundle\Entity\Appointment\Appointment */
        $dateOnly = new \DateTime($object->getStart()->format('Y-m-d'));
        $timeStart = new \DateTime($object->getStart()->format('H:i'));
        $timeEnd = new \DateTime($object->getEnd()->format('H:i'));
        $hours = $object->getColumn()->findHours($dateOnly);
        if (!$hours || !$hours->isOpen()) {
            $this->context->addViolation('This column is closed');
        }else{
            if (
            //Appointment starts before we are open
                    $timeStart->format('H:i') < $hours->getOpenTime()->format('H:i')
            ) {
                $this->context->addViolation('Appointment starts before we are open.' . $timeStart->format('H:i') . " < " . $hours->getOpenTime()->format('H:i'));
            }
            if (
            //Appointment ends after we are closed
                    $timeEnd->format('H:i') > $hours->getCloseTime()->format('H:i')
            ) {
                $this->context->addViolation('Appointment ends after we are closed. ');
            }
            if (
            //Appointment starts during lunch
                    ($timeStart->format('H:i') >= $hours->getLunchStart()->format('H:i') && $timeStart->format('H:i') < $hours->getLunchEnd()->format('H:i'))
            ) {
                $this->context->addViolation('Appointment starts during lunch.');
            }
            if (
            //Appointment starts before lunch, but doesnt end before lunch
                    ($timeStart->format('H:i') <= $hours->getLunchStart()->format('H:i') && $timeEnd->format('H:i') > $hours->getLunchStart()->format('H:i'))
            ) {
                $this->context->addViolation('Appointment starts before lunch, but doesnt end before lunch.');
            }
        }
    }

}
