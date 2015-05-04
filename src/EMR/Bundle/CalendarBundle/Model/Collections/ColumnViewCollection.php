<?php

namespace EMR\Bundle\CalendarBundle\Model\Collections;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnViewCollection extends ArrayCollection {

    const CLASS_NAME = '\EMR\Bundle\CalendarBundle\Model\ColumnView';

    public function __construct(array $elements = array()) {
        foreach ($elements as $element) {
            $this->classCheck($element);
        }
        parent::__construct($elements);
    }

    /**
     * @return \EMR\Bundle\CalendarBundle\Model\ColumnView
     */
    public function get($key) {
        return parent::get($key);
    }

    public function add($value) {
        $this->classCheck($value);
        return parent::add($value);
    }

    protected function classCheck($element) {
        if (!is_a($element, static::CLASS_NAME)) {
            throw new Exception('Member of ' . get_called_class() . ' must be '
            . static::CLASS_NAME);
        }
    }

}
