<?php

namespace EMR\Bundle\CalendarBundle\Model\Collections;

use EMR\Bundle\CalendarBundle\Entity\Column;
use MillerVein\Component\Collection\ArrayCollection;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnCollection extends ArrayCollection {

    const CLASS_NAME = '\EMR\Bundle\CalendarBundle\Entity\Column';

    public function __construct(array $elements = array()) {
        foreach ($elements as $element) {
            $this->classCheck($element);
        }
        parent::__construct($elements);
    }

    /**
     * @return Column
     */
    public function get($key) {return parent::get($key);}

    public function add($value) {
        $this->classCheck($value);
        return parent::add($value);
    }

    protected function classCheck($element) {
        if (!is_a($element, static::CLASS_NAME)) {
            throw new InvalidTypeException('Member of ' . get_called_class() . ' must be '
            . static::CLASS_NAME);
        }
    }

}
