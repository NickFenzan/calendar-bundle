<?php

namespace EMR\Bundle\CalendarBundle\Model;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\ObjectRepository;
use EMR\Bundle\CalendarBundle\Entity\Column;
use EMR\Bundle\LegacyBundle\Entity\Site;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of CalendarRequest
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CalendarRequest {
    /**
     * @var DateTime
     */
    protected $date;
    /**
     * @var Site
     */
    protected $site;
    /**
     * @var Collection|Column[]
     */
    protected $columns;
    /**
     * @var bool
     */
    protected $show_cancelled = false;
    
    /**
     * @var ObjectRepository
     */
    protected $site_repository;
    
    public function __construct(ObjectRepository $site_repository) {
        $this->site_repository = $site_repository;
        $this->setSite($site_repository->findOneBy([]));
        $this->date = new \DateTime();
    }
    
    function getDate() {
        return $this->date;
    }

    function getSite() {
        return $this->site;
    }

    function getColumns() {
        return $this->columns;
    }

    function getShowCancelled(){
        return $this->show_cancelled;
    }
    
    function setDate(DateTime $date) {
        $this->date = $date;
    }

    function setSite(Site $site) {
        $this->site = $site;
        $this->setColumns($site->getColumns());
    }

    function setColumns(Collection $columns) {
        $this->columns = $columns;
    }
    
    function setShowCancelled($show_cancelled){
        $this->show_cancelled = $show_cancelled;
    }

    function loadFromSession(Session $session){
        $this->date = $session->get('calendar_request_date',$this->date);
    }
    
    function toSession(Session $session){
        $session->set('calendar_request_date', $this->date);
        $session->set('calendar_request_site_id', $this->site->getId());
        $session->set('calendar_request_show_cancelled', $this->show_cancelled);
    }
    
    function fromSession(Session $session){
        $this->date = $session->get('calendar_request_date',$this->date);
        $site_id = $session->get('calendar_request_site_id');
        if($site_id){
            $this->setSite($this->site_repository->find($site_id));
        }
        $this->show_cancelled = $session->get('calendar_request_show_cancelled',$this->show_cancelled);
    }

}
