<?php

namespace MillerVein\CalendarBundle\Model;

/**
 * Description of PatientInterface
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
interface PatientInterface {
    public function getFname();
    public function getLname();
    public function getPid();
}
