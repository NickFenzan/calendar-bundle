<?php

namespace MillerVein\Component\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

/**
 * Description of CollectionTransformer
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
abstract class AbstractCollectionTransformer implements DataTransformerInterface {

    const REVERSE_CLASS = '';
    const FORWARD_CLASS = '\Doctrine\Common\Collections\ArrayCollection';

    /**
     * Model to Norm
     *
     * @throws UnexpectedTypeException
     */
    public function reverseTransform($value) {
        if ($value === null) {
            return null;
        }
        if (!is_a($value, static::FORWARD_CLASS)) {
            throw new UnexpectedTypeException($value, static::FORWARD_CLASS);
        }
        $class = static::REVERSE_CLASS;
        return new $class($value->toArray());
    }

    /**
     * Norm to Model
     *
     * @throws UnexpectedTypeException
     */
    public function transform($value) {
        if ($value === null) {
            return null;
        }
        if (!is_a($value, static::REVERSE_CLASS)) {
            throw new UnexpectedTypeException($value, static::REVERSE_CLASS);
        }
        $class = static::FORWARD_CLASS;
        return new $class($value->toArray());
    }

}
