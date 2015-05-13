<?php

namespace MillerVein\Component\Form\DataTransformer;

use MillerVein\Component\DateTime\DateTimeRange;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateRangeToArrayTransformer implements DataTransformerInterface {

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

        $array = array();
        $array['start'] = ($dateRange->getStart()->format('Y') == '0000') ? null : $dateRange->getStart();
        $array['end'] = ($dateRange->getEnd()->format('Y') == '9999') ? null : $dateRange->getEnd();
        $array['null'] = $dateRange->getNullValid();
        
        return $array;
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
        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
        if (empty($value['start']) && empty($value['end'])) {
            if ($value['null']) {
                return null;
            }
            return new DateTimeRange();
        }
        $range = new DateTimeRange($value['start'], $value['end']);
        if (isset($value['null']) && $value['null']) {
            $range->setNullValid(true);
        }
        return $range;
    }

}
