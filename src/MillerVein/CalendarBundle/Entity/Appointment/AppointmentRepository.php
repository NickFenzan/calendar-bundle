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
    
    public function findAppointmentsByColumnDate(Column $column, DateTime $date, $showCancelled = false){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a,c,s,p')
                ->from('MillerVeinCalendarBundle:Appointment\PatientAppointment', 'a')
                ->join('a.category', 'c')
                ->join('a.status', 's')
                ->join('a.patient', 'p')
                ->where('DATE(a.date_time) = :date')
                ->andWhere('a.column = :column');
        if (!$showCancelled){
            $qb->andWhere('s.cancelled != 1');
        }
        $qb->orderBy('a.date_time');
        $query = $qb->getQuery();
        
        $query
        ->setParameter('date', $date->format('Y-m-d'))
        ->setParameter('column', $column);
//        $query->setMaxResults(5);
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
