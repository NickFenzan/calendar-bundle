<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use \Doctrine\ORM\Query\Expr;
use EMR\Bundle\LegacyBundle\Entity\Site;
use EMR\Bundle\CalendarBundle\Entity\Category\Category;

/**
 * Description of ColumnRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnRepository extends EntityRepository{
    public function findBySiteAndCategory(Site $site, Category $category){
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->select('c')
                ->from('EMRCalendarBundle:Column', 'c')
                ->join('c.site', 's')
                ->join('c.tags', 't')
                ->join('t.categories', 'cat', Expr\Join::WITH, 'cat.id = :cat_id' )
                ->where($qb->expr()->eq('c.site', ':site'))
                ->setParameter('site', $site)
                ->setParameter('cat_id', $category->getId());
        $query = $qb->getQuery();
        
        return $query->getResult();
    }
}
