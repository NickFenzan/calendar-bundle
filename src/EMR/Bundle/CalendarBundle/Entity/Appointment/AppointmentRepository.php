<?php

namespace EMR\Bundle\CalendarBundle\Entity\Appointment;

use DateTime;
use Doctrine\ORM\EntityRepository;
use EMR\Bundle\CalendarBundle\Entity\Column;
use EMR\Bundle\LegacyBundle\Entity\Site;

/**
 * Description of AppointmentRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentRepository extends EntityRepository {

    public function findAppointmentsByDate(DateTime $start, DateTime $end = null, $cancelled = false) {
        if ($end === null) {
            $end = $start;
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a,col')
                ->from('EMRCalendarBundle:Appointment\Appointment', 'a')
                ->leftJoin('a.column', 'col')
                ->leftJoin('a.status', 's')
                ->where('a.start BETWEEN :dateOpen AND :dateClose');
        if (!$cancelled) {
            $qb->andWhere('s.cancelled != 1 OR s.cancelled IS null');
        }
        $qb->orderBy('a.start');
        $query = $qb->getQuery();

        $query
                ->setParameter('dateOpen', $start->format('Y-m-d 00:00:00'))
                ->setParameter('dateClose', $end->format('Y-m-d 23:59:59'));
        return $query->getResult();
    }

    public function findAppointmentsBySiteDate(Site $site, DateTime $start, DateTime $end = null) {
        if ($end === null) {
            $end = $start;
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a,col')
                ->from('EMRCalendarBundle:Appointment\Appointment', 'a')
                ->leftJoin('a.column', 'col')
                ->where('a.start BETWEEN :dateOpen AND :dateClose')
                ->andWhere('col.site = :site');
        $qb->orderBy('a.start');
        $query = $qb->getQuery();

        $query
                ->setParameter('dateOpen', $start->format('Y-m-d 00:00:00'))
                ->setParameter('dateClose', $end->format('Y-m-d 23:59:59'))
                ->setParameter('site', $site);
        return $query->getResult();
    }

    public function findAppointmentsByColumnDate(Column $column, DateTime $date, $showCancelled = false) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a,c')
                ->from('EMRCalendarBundle:Appointment\Appointment', 'a')
                ->join('a.category', 'c')
                ->leftJoin('a.status', 's')
                ->where('a.start BETWEEN :dateOpen AND :dateClose')
                ->andWhere('a.column = :column');
        if (!$showCancelled) {
            $qb->andWhere('s.cancelled != 1 OR s.cancelled IS null');
        }
        $qb->orderBy('a.start');
        $query = $qb->getQuery();

        $query
                ->setParameter('dateOpen', $date->format('Y-m-d 00:00:00'))
                ->setParameter('dateClose', $date->format('Y-m-d 23:59:59'))
                ->setParameter('column', $column);
        return $query->getResult();
    }

    public function findOverlappingAppointmentsByColumn($column, $startTime, $endTime, $exclude = array()) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a')
                ->from('EMRCalendarBundle:Appointment\Appointment', 'a')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->andX(
                                        $qb->expr()->gte('a.start', ':startTime'), $qb->expr()->lt('a.start', ':endTime')
                                ), $qb->expr()->andX(
                                        $qb->expr()->lte('a.start', ':startTime'), $qb->expr()->gt('a.end', ':startTime')
                                )
                ))
                ->leftJoin('a.status', 's')
                ->andWhere('a.column = :column')
                ->andWhere('s.cancelled != 1 OR s.cancelled IS null')
                ->andWhere('a.id NOT IN (:exclude)');
        $query = $qb->getQuery();
        $query
                ->setParameter('startTime', $startTime)
                ->setParameter('endTime', $endTime)
                ->setParameter('column', $column)
                ->setParameter('exclude', implode(',', $exclude));
        return $query->getResult();
    }

}
