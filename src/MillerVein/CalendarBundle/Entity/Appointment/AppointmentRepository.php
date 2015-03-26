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
    public function findAppointmentsByColumnDate(Column $column, DateTime $date, $showCancelled = false){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a,c,s,p')
                ->from('MillerVeinCalendarBundle:Appointment\PatientAppointment', 'a')
                ->join('a.category', 'c')
                ->join('a.status', 's')
                ->join('a.patient', 'p')
                ->where('DATE(a.start) = :date')
                ->andWhere('a.column = :column');
        if (!$showCancelled){
            $qb->andWhere('s.cancelled != 1');
        }
        $qb->orderBy('a.start');
        $query = $qb->getQuery();
        
        $query
        ->setParameter('date', $date->format('Y-m-d'))
        ->setParameter('column', $column);
//        $query->setMaxResults(5);
        return $query->getResult();
    }
    
    public function findOverlappingAppointmentsByColumn($column, $startTime, $endTime){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
                ->from('MillerVeinCalendarBundle:Appointment\Appointment', 'a')
                ->where(  '(('
                        . ' a.start >= :startTime AND '
                        . ' a.start < :endTime '
                        . ') OR'
                        . '('
                        . ' a.start <= :startTime AND '
                        . ' a.end > :startTime '
                        . ')) '
                        . ' AND a.column = :column');
        $query = $qb->getQuery();
        $query
                ->setParameter('startTime', $startTime)
                ->setParameter('endTime', $endTime)
                ->setParameter('column', $column);
        return $query->getResult();
                
    }
    
}

/*
* A-B Good
a.start before b.start
a.start before b.end
a.end before b.start
a.end before b.end
 * B-A Good
b.start after a.start
b.start after a.end
b.end after a.start
b.end after a.end
 * A-C Bad
a.start after c.start
a.start before c.end
a.end after c.start
a.end before c.end
 * B-C Bad
b.start after c.start
b.start before c.end
b.end after c.start
b.end after c.end
 * 

start after start is bad

*/      