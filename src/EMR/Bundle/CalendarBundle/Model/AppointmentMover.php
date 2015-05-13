<?php

namespace EMR\Bundle\CalendarBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use EMR\Bundle\CalendarBundle\Entity\Appointment\PatientAppointmentRepository;
use EMR\Bundle\CalendarBundle\Request\AppointmentMoverRequest;

/**
 * Description of AppointmentMover
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentMover {
    
    /**
     * @var EntityManager
     */
    protected $em;
    /**
     * @var PatientAppointmentRepository
     */
    protected $repo;
    
    /**
     * @var AppointmentMoverRequest
     */
    protected $request;
    
    public function __construct(EntityManager $em) {
        $this->em = $em;
        $this->repo = $em->getRepository('EMRCalendarBundle:Appointment\PatientAppointment');
    }
    public function setRequest(AppointmentMoverRequest $request){
        $this->request = $request;
    }
    public function execute(){
        if($this->request === null){
            throw new \Exception('Cannot execute without setting a request');
        }
        $appts = $this->getAppointmentsToMove();
        $this->moveAppointments($appts);
    }
    public function getAppointmentsToMove(){
        return $this->repo->match($this->request);
    }
    protected function moveAppointments(ArrayCollection $appts){
        /* @var $appt \EMR\Bundle\CalendarBundle\Entity\Appointment\PatientAppointment */
        foreach($appts as $appt){
            $appt->setColumn($this->request->getToColumn());
        }
    }
}
