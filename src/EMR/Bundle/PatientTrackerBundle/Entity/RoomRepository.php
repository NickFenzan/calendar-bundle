<?php

namespace EMR\Bundle\PatientTrackerBundle\Entity;

use Doctrine\ORM\EntityRepository;
use EMR\Bundle\LegacyBundle\Entity\Site;

/**
 * Description of RoomRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RoomRepository extends EntityRepository {

    public function findRoomBySite(Site $site) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('r')
                ->from('EMRPatientTrackerBundle:Room ', 'r')
                ->where($qb->expr()->eq('r.site', $site->getId()))
                ->getQuery();
        return  $query->getResult();
    }
    
    public function findLobbyBySite(Site $site) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('r')
                ->from('EMRPatientTrackerBundle:Room ', 'r')
                ->where($qb->expr()->eq('r.site', $site->getId()))
                ->andWhere($qb->expr()->eq('r.name', "'Lobby'"))
                ->getQuery();
        
//        return  $query->getResult();
        return $query->getOneOrNullResult();
    }

}
