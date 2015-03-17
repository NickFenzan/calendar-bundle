<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PatientRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientRepository extends EntityRepository{
    public function findAllBySearchTerm($term){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM MillerVeinCalendarBundle:Patient p '
                    . ' WHERE p.lname LIKE :term '
                    . ' OR p.fname LIKE :term'
                    . ' OR p.id LIKE :term'
                    . ' ORDER BY p.lname ASC'
            )
            ->setParameter('term', $term . '%')
            ->getResult();
    }
}
