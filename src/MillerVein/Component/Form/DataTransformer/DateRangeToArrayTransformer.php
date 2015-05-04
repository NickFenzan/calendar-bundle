<?php

namespace MillerVein\Component\Form\DataTransformer;

use MillerVein\Component\DateTime\DateTimeRange;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateRangeToArrayTransformer implements DataTransformerInterface{

    /**
     * Model to Norm
     *
     * @param mixed $dateRange
     *
     * @return array|mixed|string
     * @throws UnexpectedTypeException
     */
    public function transform($dateRange) {
        if (null === $dateRange) {
            return null;
        }

        if (!$dateRange instanceof DateTimeRange) {
            throw new UnexpectedTypeException($dateRange, 'DateRange');
        }

        return array(
            'start' => $dateRange->getStart(),
            'end' => $dateRange->getEnd()
        );
    }

    /**
     * Norm to Model
     *
     * @param $value
     *
     * @return DateTimeRange|null
     * @throws UnexpectedTypeException
     */
    public function reverseTransform($value) {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        return new DateTimeRange($value['start'], $value['end']);
    }

}
