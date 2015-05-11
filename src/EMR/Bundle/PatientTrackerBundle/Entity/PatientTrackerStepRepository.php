<?php

namespace EMR\Bundle\PatientTrackerBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;
use EMR\Bundle\LegacyBundle\Entity\Site;

/**
 * Description of PatientTrackerStepRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientTrackerStepRepository extends \Doctrine\ORM\EntityRepository{
    public function findCurrentStepsBySite(Site $site, DateTime $date = null){
        $datetime = (null === $date) ? new DateTime() : $date;
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('step')
                ->from('EMRPatientTrackerBundle:PatientTrackerStep', 'step')
                ->join('EMRLegacyBundle:Site', 'site')
                ->where($qb->expr()->eq('site.id', ':site'))
                ->setParameter('site', $site->getId())
                ->getQuery();
        return $query->getResult();
    }
}
