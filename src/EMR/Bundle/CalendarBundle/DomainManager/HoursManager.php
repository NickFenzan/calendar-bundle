<?php

namespace EMR\Bundle\CalendarBundle\DomainManager;

use Doctrine\ORM\EntityManager;
use EMR\Bundle\CalendarBundle\Entity\Hours;
use EMR\Bundle\CalendarBundle\Entity\Repository\HoursRepository;
use EMR\Bundle\CalendarBundle\Request\Admin\HoursAdminRequest;

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
        $this->repository = $entityManager->getRepository('EMRCalendarBundle:Hours');
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
    
    public function findByRequest(HoursAdminRequest $request){
        return $this->repository->findByRequest($request);
    }

}
