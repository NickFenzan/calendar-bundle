<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of HoursRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursRepository extends EntityRepository{
    public function findActiveHours() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('h')
                ->from('MillerVeinCalendarBundle:Hours', 'h')
                ->where($qb->expr()->gte('h.end_date', ':date'))
                ->orWhere($qb->expr()->isNull('h.end_date'))
                ->setParameter('date', '2015-05-01')
                ->getQuery();
        return $query->getResult();
    }
}
