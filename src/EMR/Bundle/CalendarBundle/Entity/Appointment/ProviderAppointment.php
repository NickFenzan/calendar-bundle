<?php

namespace EMR\Bundle\CalendarBundle\Entity\Appointment;

use Doctrine\ORM\Mapping as ORM;
use EMR\Bundle\CalendarBundle\Entity\RecurrenceRule;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity
 */
class ProviderAppointment extends Appointment{
    /**
     * @ORM\ManyToOne(targetEntity="EMR\Bundle\CalendarBundle\Entity\RecurrenceRule")
     * @var RecurrenceRule
     */
    protected $recurrence_rule;

    public function getType() {
        return "provider";
    }
    
    public function getRecurrenceRule() {
        return $this->recurrence_rule;
    }

    public function setRecurrenceRule(RecurrenceRule $recurrence_rule) {
        $this->recurrence_rule = $recurrence_rule;
    }


}
