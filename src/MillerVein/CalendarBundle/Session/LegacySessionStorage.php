<?php

namespace MillerVein\CalendarBundle\Session;

use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

/**
 * Description of LegacySessionStorage
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class LegacySessionStorage extends NativeSessionStorage
{
    /** {@inheritdoc} */
    protected function loadSession(array &$session = null)
    {
        if (null === $session) {
            $session = &$_SESSION;
        }

        $bags = array_merge($this->bags, array($this->metadataBag));

        foreach ($bags as $bag) {
            $key = $bag->getStorageKey();
            // We cast $_SESSION[$key] to an array, because of the SessionBagInterface::initialize() signature
            $session[$key] = isset($session[$key]) ? (array) $session[$key] : array();
            $bag->initialize($session[$key]);
        }

        $this->started = true;
        $this->closed = false;
    }
}