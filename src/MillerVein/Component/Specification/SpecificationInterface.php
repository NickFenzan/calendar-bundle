<?php

namespace MillerVein\Component\Specification;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
interface SpecificationInterface {

    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr
     */
    public function select(QueryBuilder $qb, $dqlAlias);
    
    /**
     * @param QueryBuilder $qb
     * @param string $dqlAlias
     *
     * @return Expr
     */
    public function match(QueryBuilder $qb, $dqlAlias);

    /**
     * @param Query $query
     */
    public function modifyQuery(Query $query);
}
