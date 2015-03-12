<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of AppointmentRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentRepository extends EntityRepository{
    public function findAppointmentsByColumnDateTime(Column $column, \DateTime $datetime){
        $query = $this->getEntityManager()->createQuery(
                'SELECT a '
                . ' FROM MillerVeinCalendarBundle:Appointment a '
                . ' WHERE a.date_time = :date '
                . ' AND a.column = :column '
        )
        ->setParameter('date', $datetime)
        ->setParameter('column', $column);
        return $query->getResult();
    }
}
