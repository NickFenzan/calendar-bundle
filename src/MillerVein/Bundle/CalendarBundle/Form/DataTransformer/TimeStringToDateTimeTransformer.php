<?php

namespace MillerVein\Bundle\CalendarBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TimeStringToDateTimeTransformer implements DataTransformerInterface {

    /**
     * Transforms an object (patient) to a string (number).
     *
     * @param  string|null $patient
     * @return \DateTime
     */
    public function reverseTransform($string) {
        if (null === $string) {
            return null;
        }

        return new \DateTime($string);
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  \DateTime $date
     * @return string|null
     */
    public function transform($date) {
        if (!$date) {
            return null;
        }

        return $date->format('g:i a');
    }

}
