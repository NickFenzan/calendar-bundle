<?php

namespace MillerVein\EMRBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of PatientRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientDataRepository extends EntityRepository{
    public function findAllBySearchTerm($term){
        $orderBy = 'p.lname, p.fname';
        if(stristr($term,',')){
            $parts = split(',', $term);
            $lname = (!empty(trim($parts[0])))?trim($parts[0]) . '%':null;
            $fname = (!empty(trim($parts[1])))?trim($parts[1]) . '%':null;
            $id = $term . '%';
            $namesCondition = ($lname && $fname) ? 'AND' : 'OR';
            if($fname && empty($lname)){
                $orderBy = 'p.fname, p.lname';
            }
        }else{
            $fname = $lname = $id = $term . '%';
            $namesCondition = 'OR';
            if(is_numeric($term)){
                $orderBy = 'id';
            }
        }
        
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM MillerVeinEMRBundle:PatientData p '
                    . ' WHERE '
                    . ' (p.lname LIKE :lname '
                    . $namesCondition . ' p.fname LIKE :fname)'
                    . ' OR p.pid LIKE :id'
                    . ' ORDER BY '.$orderBy
            )
            ->setParameter('fname', $fname)
            ->setParameter('lname', $lname)
            ->setParameter('id', $id)
            ->getResult();
    }
}
