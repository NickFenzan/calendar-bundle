<?php

namespace MillerVein\CalendarBundle\Model;

use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use MillerVein\CalendarBundle\Entity\Appointment\AppointmentRepository;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\EMRBundle\Entity\Site;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * I need to figure out a way to manage state on this better
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Calendar {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * Date calendar is to display
     * @var DateTime
     */
    protected $date;

    /**
     * Columns calendar is to display
     * @var Array
     */
    protected $columns;

    /**
     * 
     * @var Site
     */
    protected $site;


    /**
     *
     * @var AppointmentRepository
     */
    protected $appt_repo; 
    
    protected $show_cancelled;

// </editor-fold>

        public function __construct(AppointmentRepository $apptRepo, $display, DateTime $date = null, $showCancelled = false) {
            $this->show_cancelled = $showCancelled;
            $this->appt_repo = $apptRepo;
            $this->date = (null === $date) ? new DateTime() : $date;
            if (is_a($display, "MillerVein\EMRBundle\Entity\Site")) {
                $this->setSite($display);
            } else {
                $this->setColumns($display);
            }
    }

// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getDate() {
        return $this->date;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getSite() {
        return $this->site;
    }


    public function getAppointmentRepository() {
        return $this->appt_repo;
    }
        
    public function getShowCancelled(){
        return $this->show_cancelled;
    }
// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setDate(DateTime $date) {
        $this->date = $date;
    }

    public function setColumns($columns) {
        $this->buildColumns($columns);
    }

    public function setSite(Site $site) {
        $this->site = $site;
        $columns = $site->getColumns();
        $this->buildColumns($columns);
    }
    
    public function setShowCancelled($showCancelled){
        $this->show_cancelled = $showCancelled;
    }
    
// </editor-fold>

    protected function buildColumns($columns) {
        $this->columns = array();
        if ($columns) {
            foreach ($columns as $column) {
                if (is_a($column, "MillerVein\CalendarBundle\Entity\Column")) {
                    $this->columns[] = new CalendarColumn($this, $column, $this->show_cancelled);
                } else {
                    throw new Exception("Columns array contains non-column objects");
                }
            }
        }
    }
    
    /**
     * 
     * @param \MillerVein\CalendarBundle\Entity\Column $column
     * @return \MillerVein\CalendarBundle\Model\CalendarColumn
     */
    public function getCalendarColumnByColumn(Column $column){
        foreach($this->columns as $calCol ){
            if($calCol->getColumn() == $column){
                return $calCol;
            }
        }
    }
    
    static public function getCalendarFromSession(EntityManager $em, Session $session){
        $siteRepo = $em->getRepository("MillerVeinEMRBundle:Site");
        $apptRepo = $em->getRepository("MillerVeinCalendarBundle:Appointment\Appointment");
        
        $date = $session->get('calendar_date', new DateTime());
        $site = $session->get('calendar_site_id') ?
                $siteRepo->find($session->get('calendar_site_id')) :
                $siteRepo->findOneBy([]);
        $showCancelled = $session->get('calendar_show_cancelled',false);
        
        return new Calendar($apptRepo, $site, $date, $showCancelled);
    }
}
