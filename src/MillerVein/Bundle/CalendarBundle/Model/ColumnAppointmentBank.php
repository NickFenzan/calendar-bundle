<?php

namespace MillerVein\Bundle\CalendarBundle\Model;

use MillerVein\Bundle\CalendarBundle\Entity\Appointment\AppointmentRepository;

/**
 * Description of ColumnAppointmentBank
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnAppointmentBank {

    protected $appointments;

    public function __construct(AppointmentRepository $apptRepo, CalendarColumn $calCol, $showCancelled = false) {
        $appts = $apptRepo->findAppointmentsByColumnDate(
                $calCol->getColumn(), $calCol->getCalendar()->getDate(), $showCancelled);
        $schedulingIncrement = $calCol->getHours()->getSchedulingIncrement();

        foreach ($appts as $appt) {
            $this->appointments[] = new DisplayAppointment($appt, $schedulingIncrement);
        }
    }
    
    public function getAppointments(){
        return $this->appointments;
    }

//    ApptBank
//        Appts
//        - Want to keep track of what appointments have displayed
//            Appointment Fragments
//            - Keeps track of display information like whether its first, last, or middle.
//            
//    foreach appointment
//        set displayAppointment for timeslot
        
    
    
}