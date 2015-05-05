<?php

namespace MillerVein\Component\Form\DataTransformer;

use DateTime;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TwentyFourToTwelveHourArray implements DataTransformerInterface{
    public function reverseTransform($value) {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        if($value['ampm'] == 'PM' && $value['hour']>0){
            $value['hour'] = $value['hour'] + 12;
        }
        unset($value['ampm']);
        return $value;
    }

    public function transform($value) {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }
        
        if($value['hour'] === 0){
            $value['hour'] = 12;
            $value['ampm'] = 'AM';
        }elseif($value['hour']<12){
            $value['ampm'] = 'AM';
        }else{
            $value['hour'] = $value['hour'] - 12;
            $value['ampm'] = 'PM';
        }
        
        return $value;
    }

}
