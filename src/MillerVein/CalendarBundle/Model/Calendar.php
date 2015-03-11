<?php

namespace MillerVein\CalendarBundle\Model;

use DateTime;
use Exception;
use MillerVein\CalendarBundle\Entity\Site;

/**
 * Description of Calendar
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Calendar {

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

    public function __construct(DateTime $date, $display) {
        $this->date = $date;
        if (is_a($display, "MillerVein\CalendarBundle\Entity\Site")) {
            $this->setSite($display);
        } else {
            $this->setColumns($display);
        }
    }

    public function getDate() {
        return $this->date;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getSite() {
        return $this->site;
    }

    public function setDate(DateTime $date) {
        $this->date = $date;
    }

    public function setColumns($columns) {
        $this->buildColumns($columns);
    }

    protected function buildColumns($columns) {
        $this->columns = array();
        foreach ($columns as $column) {
            if (is_a($column, "MillerVein\CalendarBundle\Entity\Column")) {
                $this->columns[] = new CalendarColumn($column, $this->date);
            } else {
                throw new Exception("Columns array contains non-column objects");
            }
        }
    }

    public function setSite(Site $site) {
        $this->site = $site;
        $columns = $site->getColumns();
        $this->buildColumns($columns);
    }

}
