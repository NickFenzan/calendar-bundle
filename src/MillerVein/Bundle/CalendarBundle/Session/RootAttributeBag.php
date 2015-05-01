<?php

namespace MillerVein\Bundle\CalendarBundle\Session;

use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

/**
 * Description of RootAttributeBag
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RootAttributeBag implements SessionBagInterface{
    private $name = 'single_attribute';

    /** @var string */
    private $storageKey;

    /** @var mixed */
    private $attribute;

    public function __construct($storageKey)
    {
        $this->storageKey = $storageKey;
    }

    /** {@inheritdoc} */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /** {@inheritdoc} */
    public function initialize(array &$array)
    {
        $attribute = !empty($array) ? $array[0] : null;
        $this->attribute = &$attribute;
    }

    /** {@inheritdoc} */
    public function getStorageKey()
    {
        return $this->storageKey;
    }

    /** {@inheritdoc} */
    public function clear()
    {
        $this->attribute = null;
    }

    public function get()
    {
        return $this->attribute;
    }

    public function set($value)
    {
        $this->attribute = $value;
    }
}
