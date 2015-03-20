<?php

namespace MillerVein\CalendarBundle\Entity\Appointment;

use DateTime;
use Doctrine\ORM\EntityRepository;
use MillerVein\CalendarBundle\Entity\Column;

/**
 * Description of AppointmentRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentRepository extends EntityRepository{
    public function findAppointmentsByColumn(Column $column){
        $query = $this->getEntityManager()->createQuery(
                'SELECT a '
                . ' FROM MillerVeinCalendarBundle:Appointment\Appointment a '
                . ' WHERE a.column = :column '
        )
        ->setParameter('column', $column);
        return $query->getResult();
    }
    
    public function findAppointmentsByColumnDate(Column $column, DateTime $date){
        $query = $this->getEntityManager()->createQuery(
                'SELECT a '
                . ' FROM MillerVeinCalendarBundle:Appointment\Appointment a '
                . ' WHERE DATE(a.date_time) = :date '
                . ' AND a.column = :column '
                . ' ORDER BY a.date_time '
        )
        ->setParameter('date', $date)
        ->setParameter('column', $column);
        return $query->getResult();
    }
    
    public function findAppointmentsByColumnDateTime(Column $column, DateTime $datetime){
        $query = $this->getEntityManager()->createQuery(
                'SELECT a '
                . ' FROM MillerVeinCalendarBundle:Appointment\Appointment a '
                . ' WHERE a.date_time = :date '
                . ' AND a.column = :column '
        )
        ->setParameter('date', $datetime)
        ->setParameter('column', $column);
        return $query->getResult();
    }
}
