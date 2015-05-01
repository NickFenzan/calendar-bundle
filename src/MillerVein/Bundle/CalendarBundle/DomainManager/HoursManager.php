<?php

namespace MillerVein\Bundle\CalendarBundle\DomainManager;

use Doctrine\ORM\EntityManager;
use MillerVein\Bundle\CalendarBundle\Entity\Hours;
use MillerVein\Bundle\CalendarBundle\Entity\Repository\HoursRepository;

/**
 * Description of HoursManager
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursManager {

    /**
     * @var EntityManager 
     */
    protected $entityManager;

    /**
     * @var HoursRepository 
     */
    protected $repository;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository('MillerVeinCalendarBundle:Hours');
    }

    
    public function getAllHours(){
        return $this->repository->findAll();
    }
    
    public function getActiveHours() {
        return $this->repository->findActiveHours();
    }

    public function save(Hours $hours) {
        $this->entityManager->persist($hours);
        $this->entityManager->flush();
    }
    
    public function delete(Hours $hours) {
        $this->entityManager->remove($hours);
        $this->entityManager->flush();
    }

}
