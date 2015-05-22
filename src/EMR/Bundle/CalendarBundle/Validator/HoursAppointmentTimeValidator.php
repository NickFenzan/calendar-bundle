<?php

namespace EMR\Bundle\CalendarBundle\Validator;

use DateTime;
use Doctrine\ORM\EntityManager;
use EMR\Bundle\CalendarBundle\Entity\Appointment\Appointment;
use EMR\Bundle\CalendarBundle\Entity\Hours;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursAppointmentTimeValidator extends ConstraintValidator {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint) {
        /* @var $object Appointment */
        $dateOnly = new DateTime($object->getStart()->format('Y-m-d'));
        $timeStart = new DateTime($object->getStart()->format('H:i'));
        $timeEnd = new DateTime($object->getEnd()->format('H:i'));
        $hours = $object->getColumn()->findHours($dateOnly);
        if (!$hours || !$hours->isOpen()) {
            $this->context->addViolation('This column is closed');
        } else {
            $this->durationTimeSlotValidation($hours, $timeStart);
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
            if (is_a($hours->getLunchStart(), '\DateTime') && is_a($hours->getLunchEnd(), '\DateTime')) {
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

    protected function durationTimeSlotValidation(Hours $hours, DateTime $request) {
        $timestamp = $request->getTimestamp();
        $interval = $hours->getSchedulingIncrement()*60;
        if($hours->hasLunch() && $request > $hours->getLunchStart()){
                $start = $hours->getLunchEnd()->getTimestamp();
        }else{
                $start = $hours->getOpenTime()->getTimestamp();
            
        }
        if(($timestamp - $start) % $interval != 0){
            $this->context->addViolation('Appointment does not fall into an allotted slot.');
        }
    }

}
