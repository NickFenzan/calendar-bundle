<?php

namespace EMR\Bundle\CalendarBundle\Specification;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use EMR\Bundle\CalendarBundle\Entity\UtilizationGoal;
use MillerVein\Component\Specification\SpecificationInterface;

/**
 * Description of FilterGoal
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class FilterGoals implements SpecificationInterface {

    private $goals;

    public function __construct(array $goals) {
        $this->goals = array();
        foreach($goals as $goal){
            $this->goals[] = $goal->getId();
        }
    }

    public function select(QueryBuilder $qb, $dqlAlias) {
        
    }

    public function match(QueryBuilder $qb, $dqlAlias) {
        $qb->setParameter('goals', $this->goals);

        return $qb->expr()->in($dqlAlias . '.goals', ':goals');
    }

    public function modifyQuery(Query $query) {
        
    }

}
