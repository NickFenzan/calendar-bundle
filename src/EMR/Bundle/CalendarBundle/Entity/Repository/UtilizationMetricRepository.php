<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use MillerVein\Component\Specification\SpecificationInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationMetricRepository extends EntityRepository {

    public function match(SpecificationInterface $specification) {
//        if (!$specification->supports($this->getEntityName())) {
//            throw new InvalidArgumentException("Specification not supported by this repository.");
//        }

        $qb = $this->createQueryBuilder('r');
//        $selectExpr = $specification->select($qb, 'r');
        $whereExpr = $specification->match($qb, 'r');

//        $qb->select($selectExpr);
        $qb->where($whereExpr);
        $query = $qb->getQuery();

        $specification->modifyQuery($query);

        return $query->getResult();
    }

}
