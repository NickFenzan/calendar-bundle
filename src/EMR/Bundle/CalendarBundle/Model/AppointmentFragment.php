<?php

namespace EMR\Bundle\CalendarBundle\Model;

use EMR\Bundle\CalendarBundle\Entity\Appointment\Appointment;

/**
 * Description of AppointmentFragment
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFragment {
    /**
     * @var string
     */
    protected $text;
    /**
     * @var string
     */
    protected $link_target;
    /**
     * @var Appointment
     */
    protected $appointment;
    /**
     * @var \DateTime
     */
    protected $date_time;
    /**
     * @var bool
     */
    protected $first = false;
    /**
     * @var bool
     */
    protected $last = false;
    
    public function __construct(Appointment $appointment) {
        $this->appointment = $appointment;
    }
    
    function getText() {
        return $this->text;
    }

    function getLinkTarget() {
        return $this->link_target;
    }

    function getAppointment() {
        return $this->appointment;
    }
    
    function getDateTime() {
        return $this->date_time;
    }
        
    function isFirst(){
        return $this->first;
    }
    
    function isLast(){
        return $this->last;
    }
    
    function setText($text) {
        $this->text = $text;
    }

    function setLinkTarget($link_target) {
        $this->link_target = $link_target;
    }

    function setAppointment($appointment) {
        $this->appointment = $appointment;
    }
    
    function setDateTime(\DateTime $date_time) {
        $this->date_time = $date_time;
    }
        
    function setFirst($bool){
        $this->first = (bool) $bool;
    } 
    
    function setLast($bool){
        $this->last = (bool) $bool;
    }
}
