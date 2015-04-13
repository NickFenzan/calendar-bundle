<?php

namespace MillerVein\CalendarBundle\Model;

use DateTime;
use MillerVein\CalendarBundle\Model\Collections\ColumnCollection;
use MillerVein\EMRBundle\Entity\Site;
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
     * @var ColumnCollection
     */
    protected $columns;
    
    public function __construct() {
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

    function setDate(DateTime $date) {
        $this->date = $date;
    }

    function setSite(Site $site) {
        $this->site = $site;
        $this->setColumns(new ColumnCollection($site->getColumns()->toArray()));
    }

    function setColumns(ColumnCollection $columns) {
        $this->columns = $columns;
    }

    function loadFromSession(Session $session){
        $this->date = $session->get('calendar_request_date',$this->date);
    }
    
    function toSession(Session $session){
        $session->set('calendar_request_date', $this->date);
    }
    
    function fromSession(Session $session){
        $this->date = $session->get('calendar_request_date',$this->date);
    }

}
