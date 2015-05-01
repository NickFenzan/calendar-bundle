<?php

namespace MillerVein\Bundle\CalendarBundle\Model;

use MillerVein\Bundle\CalendarBundle\Entity\Appointment\Appointment;

/**
 * Description of AppointmentFragmentBuilder
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFragmentBuilder {

    const EMR_PATIENT_LINK = "/interface/patient_file/summary/demographics.php?set_pid=";

    public function buildFragments(Appointment $appointment, $schedule_increment) {
        $fragments = array();
        $fragmentCount = $this->getFragmentCount($appointment->getDuration(), $schedule_increment);
        for ($i = 0; $i < $fragmentCount; $i++) {
            $fragments[] = $this->buildFragment($appointment, $i, $schedule_increment);
        }
        return new Collections\AppointmentFragmentCollection($fragments);
    }

    protected function buildFragment($appointment, $fragmentNumber, $schedule_increment) {
        $apptFragment = new AppointmentFragment($appointment);
        $fragmentCount = $this->getFragmentCount($appointment->getDuration(), $schedule_increment);

        //Every fragment
        $this->setFragmentDateTime($apptFragment, $appointment, $fragmentNumber, $schedule_increment);

        //First fragment
        if ($fragmentNumber === 0) {
            $this->buildFirstFragment($apptFragment, $appointment);
        }

        //Last fragment
        if ($fragmentNumber == $fragmentCount-1) {
            $apptFragment->setLast(true);
        }
        
        return $apptFragment;
    }

    protected function setFragmentDateTime(AppointmentFragment &$apptFragment, Appointment $appointment, $fragmentNumber, $schedule_increment) {
        $fragmentTime = clone $appointment->getStart();
        $intervalMinutes = $fragmentNumber * $schedule_increment;
        $interval = new \DateInterval('PT' . $intervalMinutes . 'M');
        $fragmentTime->add($interval);

        $apptFragment->setDateTime($fragmentTime);
    }

    protected function getFragmentCount($duration, $increment) {
        return round($duration / $increment);
    }

    protected function buildFirstFragment(AppointmentFragment &$apptFragment, $appointment) {
        $apptFragment->setFirst(true);
        switch ($appointment->getType()) {
            case Appointment::TYPE_PATIENT:
                $this->buildFirstPatientFragment($apptFragment, $appointment);
        }
    }

    protected function buildFirstPatientFragment(&$apptFragment, $appointment) {
        /* @var $patient \MillerVein\Bundle\EMRBundle\Entity\PatientData */
        $patient = $appointment->getPatient();
        $text = $appointment->getStatus()->getLegacyId() . ' ';
        $text .= ($patient->getNickname()) ? $patient->getNickname() : $patient->getFname();
        $text .= ' ' . $patient->getLname();
//        $text .= $apptFragment->getDateTime()->format('m.d.Y H:i');
        $apptFragment->setText($text);
        $apptFragment->setLinkTarget(static::EMR_PATIENT_LINK . $patient->getId());
    }

}
