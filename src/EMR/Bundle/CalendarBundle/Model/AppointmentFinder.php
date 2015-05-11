<?php

namespace EMR\Bundle\CalendarBundle\Model;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManager;
use EMR\Bundle\CalendarBundle\Entity\Appointment\PatientAppointment;
use EMR\Bundle\CalendarBundle\Entity\Category\PatientCategory;
use EMR\Bundle\CalendarBundle\Entity\Column;
use EMR\Bundle\CalendarBundle\Entity\Hours;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFinder {

    protected $em;

    /**
     * @var AppointmentFinderRequest 
     */
    protected $request;
    protected $results;

    const RESULT_LIMIT = 3;
    const CONFLICT_LIMIT = 0;

    public function __construct(EntityManager $em) {
        set_time_limit(30);
        $this->em = $em;
        $this->results = array();
    }

    public function findAppointments(AppointmentFinderRequest $appt_request) {
        $this->request = $appt_request;
        $this->loopDays();
        return $this->results;
    }

    protected function loopDays() {
        $startDate = clone $this->request->getMinDate();
        $endDate = clone $this->request->getMaxDate();

        //Loop Days
        for ($currentDate = clone $startDate; $currentDate <= $endDate; $currentDate->add(new DateInterval("P1D"))) {
            if (!$this->isDateValid($currentDate)) {
                continue;
            }

            $cols = $this->findColumnsBySite();
            $this->loopColumns($cols, $currentDate);
        }
    }

    protected function loopColumns(array $cols, \DateTime $date) {
        //Loop Columns
        foreach ($cols as $column) {
            /* @var $column Column */
            /* @var $hours Hours */
            $hours = $column->findHours($date);
            //If today doesn't have hours or is closed, move on.
            if (!$hours || !$hours->isOpen()) {
                continue;
            }

            $this->loopTimesRouter($date, $column, $hours);
        }
    }

    protected function loopTimesRouter(\DateTime $date, Column $column, Hours $hours) {
        $start = $this->getStart($date, $hours);
        $end = $this->getEnd($date, $hours);

        if ($hours->hasLunch()) {
            $lunchStart = DateTimeUtility::moveTimeToDate($date, $hours->getLunchStart());
            $lunchEnd = DateTimeUtility::moveTimeToDate($date, $hours->getLunchEnd());
            if ($start < $lunchStart) {
                $this->loopTimes($start, $lunchStart, $hours, $column);
            }else{
                $this->loopTimes($start, $end, $hours, $column);
            }
        } else {
            $this->loopTimes($start, $end, $hours, $column);
        }
    }

    protected function loopTimes(DateTime $start, DateTime $end, Hours $hours, Column $column) {
        if (count($this->results) >= static::RESULT_LIMIT) {
            return;
        }
        $appointmentInterval = $this->getRequestedInterval();
        for ($currentTime = clone $start; $currentTime < $end; $currentTime->add($hours->getSchedulingInterval())) {
            $requestedEndTime = clone $currentTime;
            $requestedEndTime->add($appointmentInterval);

            //Skip slots that conflict with the open hours
            if ($hours->doTimesConflict($currentTime, $requestedEndTime)) {
                continue;
            }

            if (!$this->appointmentConflictCheck($column, $currentTime, $requestedEndTime)) {
                continue;
            }
            $this->addResult($column, clone $currentTime);
            if (count($this->results) >= static::RESULT_LIMIT) {
                break;
            }
        }
    }

    protected function appointmentConflictCheck(Column $column, \DateTime $requestedStart, \DateTime $requestedEnd) {
        $apptRepo = $this->em->getRepository('EMRCalendarBundle:Appointment\Appointment');
        $appointments = $apptRepo->findOverlappingAppointmentsByColumn($column, $requestedStart, $requestedEnd);
        
        $overlapsAllowed = $this->request->getCategory()->getOverlapsAllowed();
        foreach($appointments as $appointment){
            $appointmentOverlaps = $appointment->getCategory()->getOverlapsAllowed();
            $overlapsAllowed = ( $appointmentOverlaps > $overlapsAllowed ) ? $appointmentOverlaps : $overlapsAllowed;
        }
        $conflicts = count($appointments);
        return ($conflicts <= $overlapsAllowed);
    }

    protected function addResult(Column $column, \DateTime $start) {
        $category = $this->request->getCategory();
        $appt = new PatientAppointment();
        $appt->setColumn($column);
        $appt->setCategory($category);
        $appt->setStart($start);
        $appt->setDuration($category->getDefaultDuration());
        $this->results[] = $appt;
    }

    protected function isDateValid(\DateTime $date) {
        $dayOfWeek = $this->request->getDayOfWeek();
        return ($dayOfWeek !== null) ? ($date->format('N') == $dayOfWeek) : true;
    }

    protected function findColumnsBySite() {
        $colRepo = $this->em->getRepository('EMRCalendarBundle:Column');
        $site = $this->request->getSite();
        $category = $this->request->getCategory();

        return $colRepo->findBySiteAndCategory($site, $category);
    }

    protected function getStart(\DateTime $date, Hours $hours) {
        $startTime = ($this->request->getMinTime()) ?
                $this->request->getMinTime() : $hours->getOpenTime();
        return DateTimeUtility::moveTimeToDate($date, $startTime);
    }

    protected function getLunchStart(\DateTime $date, Hours $hours) {
        
    }

    protected function getEnd(\DateTime $date, Hours $hours) {
        $endTime = ($this->request->getMaxTime()) ?
                $this->request->getMaxTime() : $hours->getCloseTime();
        return DateTimeUtility::moveTimeToDate($date, $endTime);
    }

    protected function getRequestedInterval() {
        $appointmentDuration = $this->request->getDuration();
        return new \DateInterval("PT{$appointmentDuration}M");
    }

}
