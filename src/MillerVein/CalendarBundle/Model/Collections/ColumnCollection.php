<?php

namespace MillerVein\CalendarBundle\Model\Collections;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnCollection extends ArrayCollection {

    const CLASS_NAME = '\MillerVein\CalendarBundle\Entity\Column';

    public function __construct(array $elements = array()) {
        foreach ($elements as $element) {
            $this->classCheck($element);
        }
        parent::__construct($elements);
    }

    /**
     * @return \MillerVein\CalendarBundle\Entity\Column
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
