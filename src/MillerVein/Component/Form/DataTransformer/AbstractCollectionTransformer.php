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
    const COLLECTION_INTERFACE = 'Doctrine\Common\Collections\Collection';

    /**
     * Model to Norm
     *
     * @throws UnexpectedTypeException
     */
    public function reverseTransform($value) {
        if ($value === null) {
            return null;
        }
        if (!class_implements(static::COLLECTION_INTERFACE)) {
            throw new UnexpectedTypeException($value, static::COLLECTION_INTERFACE);
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
        if (!class_implements(static::COLLECTION_INTERFACE)) {
            throw new UnexpectedTypeException($value, static::COLLECTION_INTERFACE);
        }
        $class = static::FORWARD_CLASS;
        return new $class($value->toArray());
    }

}
