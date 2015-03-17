<?php

namespace MillerVein\CalendarBundle\Entity\Appointment;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity
 */
class ProviderAppointment extends Appointment{
    
    public function getType() {
        return "provider";
    }
}
