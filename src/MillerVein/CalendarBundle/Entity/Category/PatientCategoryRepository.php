<?php

namespace MillerVein\CalendarBundle\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Description of CategoryRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientCategoryRepository extends EntityRepository {

    public function findAllowedByTags($tags) {
        $tagIdArray=array();
        foreach($tags->getIterator() as $tag){
            $tagIdArray[] = $tag->getId();
        }
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->addSelect('c')
            ->from('MillerVeinCalendarBundle:Category\PatientCategory', 'c')
            ->join('c.required_column_tags', 'tags')
            ->where('tags IN(:tags)')
            ->setParameter('tags', $tagIdArray)
            ->getQuery();
        return $query->getResult();
    }

}
