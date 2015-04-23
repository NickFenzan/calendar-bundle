<?php

namespace MillerVein\CalendarBundle\Model;

use DateInterval;
use MillerVein\CalendarBundle\Entity\Appointment\AppointmentRepository;
use MillerVein\CalendarBundle\Entity\Column;
use MillerVein\CalendarBundle\Model\Calendar;
use MillerVein\CalendarBundle\Model\Collections\AppointmentFragmentCollection;
use MillerVein\CalendarBundle\Model\Collections\ColumnViewCollection;
use MillerVein\CalendarBundle\Model\Collections\TimeSlotCollection;

/**
 * Description of CalendarBuilder
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CalendarBuilder {

    protected $apptRepo;

    public function __construct(AppointmentRepository $appointment_repository) {
        $this->apptRepo = $appointment_repository;
    }

    public function buildCalendar(CalendarRequest $request) {
        $calendar = new Calendar();
        $columns = $request->getColumns();
        $date = $request->getDate();

        //Hardcode interval for now
        $interval = new \DateInterval('PT15M');
        $appts = $this->findAppointmentsByColumnsAndDate($columns, $date, $request->getShowCancelled());
        $fragments = $this->convertAppointmentsToFragments($appts);

        $columnViewCollection = new ColumnViewCollection();

        $earliestTime = (!$fragments->isEmpty()) ? DateTimeUtility::moveTimeToDate($date, $fragments->earliestTime()) : null;
        $latestTime = (!$fragments->isEmpty()) ? DateTimeUtility::moveTimeToDate($date, $fragments->latestTime()) : null;
        $smallestIncrement = null;
        
        if($latestTime){
            //We have to add one step to this because we want to use it as an outer limit.
            $latestTime->add($interval);
        }
        
        foreach ($columns as $column) {
            /* @var $column Column */
            $hours = $column->findHours($date);
            if ($hours && $hours->isOpen()) {
                $openTime = DateTimeUtility::moveTimeToDate($date, $hours->getOpenTime());
                $closeTime = DateTimeUtility::moveTimeToDate($date, $hours->getCloseTime());
                if ($openTime < $earliestTime || $earliestTime == null) {
                    $earliestTime = $openTime;
                }
                if ($closeTime > $latestTime || $latestTime == null) {
                    $latestTime = $closeTime;
                }
                if ($smallestIncrement == null || $smallestIncrement > $hours->getSchedulingInterval()){
                    $smallestIncrement = $hours->getSchedulingInterval();
                }
            }
        }

        foreach ($columns as $column) {
            $columnView = new ColumnView($column);
            $timeSlotCollection = new TimeSlotCollection();
            /* @var $column Column */
            $hours = $column->findHours($date);
            if ($hours && $hours->isOpen()) {
                $interval = $hours->getSchedulingInterval();
                $openTime = DateTimeUtility::moveTimeToDate($date, $hours->getOpenTime());
                $closeTime = DateTimeUtility::moveTimeToDate($date, $hours->getCloseTime());
                if ($earliestTime !== null && $earliestTime < $openTime) {
                    TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $earliestTime, $openTime, $smallestIncrement, $interval, true);
                }
                if ($hours->hasLunch()) {
                    $lunchStart = DateTimeUtility::moveTimeToDate($date, $hours->getLunchStart());
                    $lunchEnd = DateTimeUtility::moveTimeToDate($date, $hours->getLunchEnd());
                    TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $openTime, $lunchStart, $smallestIncrement, $interval);
                    TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $lunchStart, $lunchEnd, $smallestIncrement, $interval, true, 'Lunch');
                    TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $lunchEnd, $closeTime, $smallestIncrement, $interval);
                } else {
                    TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $openTime, $closeTime, $smallestIncrement, $interval);
                }
                if ($closeTime !== null && $closeTime < $latestTime) {
                    TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $closeTime, $latestTime, $smallestIncrement, $interval, true);
                }
            } elseif ($fragments->hasColumn($column)) {
                TimeSlotCollectionFactory::addTimeSlots($timeSlotCollection, $column, $earliestTime, $latestTime, $smallestIncrement, $interval, true);
            } else {
                continue;
            }
            $timeSlotCollection->applyAppointmentFragmentCollection($fragments);
            $columnView->setTimeSlotCollection($timeSlotCollection);
            $columnViewCollection->add($columnView);
        }
        $calendar->setColumns($columnViewCollection);


        return $calendar;
    }

    protected function findAppointmentsByColumnsAndDate($columns, $date, $showCancelled = false) {
        $appts = array();
        foreach ($columns as $column) {
            $appts = array_merge($appts, $this->apptRepo->findAppointmentsByColumnDate($column, $date, $showCancelled));
        }
        return $appts;
    }

    protected function convertAppointmentsToFragments($appts) {
        $appointmentFragmentBuilder = new AppointmentFragmentBuilder();
        $fragments = new AppointmentFragmentCollection();
        foreach ($appts as $appt) {
            $fragments->merge($appointmentFragmentBuilder->buildFragments($appt, 15));
        }
        return $fragments;
    }

}
