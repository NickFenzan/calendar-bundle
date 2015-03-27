<?php

namespace MillerVein\CalendarBundle\Model;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFinder {

    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function findAppointments(AppointmentFinderRequest $appt_request) {
        $appts = array();
        $startDate = clone $appt_request->getMinDate();
        $endDate = clone $appt_request->getMaxDate();
        $dateInterval = new DateInterval("P1D");
        $colRepo = $this->em->getRepository('MillerVeinCalendarBundle:Column');
        $apptRepo = $this->em->getRepository('MillerVeinCalendarBundle:Appointment\Appointment');
        $category = $appt_request->getCategory();
        $duration = $appt_request->getDuration();
        
        for($workingDate = clone $startDate; $workingDate <= $endDate; $workingDate->add($dateInterval)){
            
            $cols = $colRepo->findBySiteAndCategory($appt_request->getSite(),$category);
            
//            echo "<hr>";
//            echo $workingDate->format("m/d/Y");
//            echo "<br>";
            foreach($cols as $column){
//                echo $column->getName();
//                echo "<br>";
                /** @var $column MillerVein\CalendarBundle\Entity\Column */
                $hours = $column->findHours($workingDate);
                if (!$hours){
                    continue;
                }
                
                
                $interval = new DateInterval("PT{$duration}M");
                $hoursIterator = $hours->getIterator();
                for($hoursIterator->rewind();$hoursIterator->valid();$hoursIterator->next()){
                    if(is_a($hoursIterator->current(),'DateTime')){
                        $currentLoopTime = new DateTime($workingDate->format('Y-m-d') . ' ' . $hoursIterator->current()->format('H:i'));
                        $endTime = clone $currentLoopTime;
                        $endTime->add($interval);
                        
                        $conflicts = $apptRepo->findOverlappingAppointmentsByColumn($column,$currentLoopTime,$endTime);
                        if(count($conflicts) == 0){
                            $appt = new PatientAppointment();
                            $appt->setColumn($column);
                            $appt->setCategory($category);
                            $appt->setStart($currentLoopTime);
                            $appt->setDuration($duration);
                            $appts[] = $appt;
                            if (count($appts) >= 3){
                                return $appts;
                            }
                        }
                    }
                }
            }
        }
        return $appts;
    }
    
}
