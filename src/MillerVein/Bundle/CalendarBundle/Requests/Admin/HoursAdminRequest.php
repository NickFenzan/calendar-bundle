<?php
namespace MillerVein\Bundle\CalendarBundle\Request\Admin;

use Doctrine\Common\Collections\ArrayCollection;
/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursAdminRequest {
    /**
     * @var ArrayCollection
     */
    protected $columns;
    /**
     * @var boolean
     */
    protected $active;
    public function __construct() {
        $this->columns = new ArrayCollection();
    }
}
