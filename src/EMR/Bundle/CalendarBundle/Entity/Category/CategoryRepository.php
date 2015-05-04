<?php

namespace EMR\Bundle\CalendarBundle\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Description of CategoryRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CategoryRepository extends EntityRepository {
    const ENTITY_NAME = "Category\Category";

    public function findAllowedByTags($tags) {
        $tagIdArray=array();
        foreach($tags->getIterator() as $tag){
            $tagIdArray[] = $tag->getId();
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->addSelect('c')
            ->from('MillerVeinCalendarBundle:'.static::ENTITY_NAME, 'c')
            ->join('c.required_column_tags', 'tags')
            ->where('tags IN(:tags)')
            ->orderBy('c.name')
            ->setParameter('tags', $tagIdArray)
            ->getQuery();
        return $query->getResult();
    }

}
