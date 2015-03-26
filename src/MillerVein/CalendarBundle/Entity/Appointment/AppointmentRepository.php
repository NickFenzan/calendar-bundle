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
class AppointmentRepository extends EntityRepository {

    public function findAppointmentsByColumnDate(Column $column, DateTime $date, $showCancelled = false) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a,c')
                ->from('MillerVeinCalendarBundle:Appointment\Appointment', 'a')
                ->join('a.category', 'c')
                ->leftJoin('a.status', 's')
                ->where('DATE(a.start) = :date')
                ->andWhere('a.column = :column');
        if (!$showCancelled) {
            $qb->andWhere('s.cancelled != 1 OR s.cancelled IS null');
        }
        $qb->orderBy('a.start');
        $query = $qb->getQuery();

        $query
                ->setParameter('date', $date->format('Y-m-d'))
                ->setParameter('column', $column);
        return $query->getResult();
    }

    public function findOverlappingAppointmentsByColumn($column, $startTime, $endTime) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
                ->from('MillerVeinCalendarBundle:Appointment\Appointment', 'a')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->andX(
                                        $qb->expr()->gte('a.start', ':startTime'), $qb->expr()->lt('a.start', ':endTime')
                                ), $qb->expr()->andX(
                                        $qb->expr()->lte('a.start', ':startTime'), $qb->expr()->gt('a.end', ':startTime')
                                )
                ))
                ->andWhere('a.column = :column');
        $query = $qb->getQuery();
        $query
                ->setParameter('startTime', $startTime)
                ->setParameter('endTime', $endTime)
                ->setParameter('column', $column);
        return $query->getResult();
    }
}