<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace EMR\Bundle\CalendarBundle\Model\Reports;

use DateTime;
use Doctrine\Common\Collections\Collection;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
interface DateRangedCalendarCalculatorInterface {
    public function setStartDate(DateTime $startDate);
    public function setEndDate(DateTime $endDate);
    public function setColumns(Collection $columns);
    public function calculate();
    public function getResult();
}
