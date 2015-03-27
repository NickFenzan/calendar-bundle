<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\EntityRepository;
use MillerVein\EMRBundle\Entity\Site;
use MillerVein\CalendarBundle\Entity\Category\Category;

/**
 * Description of ColumnRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnRepository extends EntityRepository{
    public function findBySiteAndCategory(Site $site, Category $category){
        $qb = $this->getEntityManager()->createQueryBuilder();
        
        $qb->select('c')
                ->from('MillerVeinCalendarBundle:Column', 'c')
                ->join('c.site', 's')
                ->join('c.tags', 't')
                ->join('t.categories', 'cat', \Doctrine\ORM\Query\Expr\Join::WITH, 'cat.id = :cat_id' )
                ->where($qb->expr()->eq('c.site', ':site'))
                ->setParameter('site', $site)
                ->setParameter('cat_id', $category->getId());
        $query = $qb->getQuery();
        
        return $query->getResult();
    }
}
