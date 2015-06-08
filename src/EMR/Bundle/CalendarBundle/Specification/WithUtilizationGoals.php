<?php

namespace EMR\Bundle\CalendarBundle\Specification;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use MillerVein\Component\Specification\SpecificationInterface;

/**
 * Description of WithUtilizationGoals
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class WithUtilizationGoals implements SpecificationInterface{
    public function select(QueryBuilder $qb, $dqlAlias) {
        
    }

    public function match(QueryBuilder $qb, $dqlAlias) {
        
    }

    public function modifyQuery(Query $query) {
        
    }

}
