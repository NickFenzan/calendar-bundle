<?php

namespace EMR\Bundle\PatientTrackerBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;
use EMR\Bundle\LegacyBundle\Entity\Site;

/**
 * Description of PatientTrackerVisitRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientTrackerVisitRepository extends EntityRepository {

    public function findActiveVisitsBySite(Site $site){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('v')
                ->from('EMRPatientTrackerBundle:PatientTrackerVisit', 'v')
                ->join('v.appointment', 'a')
                ->join('a.column', 'c')
                ->where($qb->expr()->eq('v.checked_out', $qb->expr()->literal(false)))
                ->andWhere($qb->expr()->eq('c.site', ':site'))
                ->setParameter(':site', $site->getId())
                ->getQuery();
        return $query->getResult();
    }

}
