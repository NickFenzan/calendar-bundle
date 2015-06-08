<?php

namespace MillerVein\Component\Specification;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AndX implements SpecificationInterface {

    private $children;

    public function __construct() {
        $this->children = func_get_args();
    }

    public function match(QueryBuilder $qb, $dqlAlias) {
        return call_user_func_array(
                array($qb->expr(), 'andX'), array_map(function ($specification) use ($qb, $dqlAlias) {
                    return $specification->match($qb, $dqlAlias);
                }, $this->children
        ));
    }

    public function modifyQuery(Query $query) {
        foreach ($this->children as $child) {
            $child->modifyQuery($query);
        }
    }

}
