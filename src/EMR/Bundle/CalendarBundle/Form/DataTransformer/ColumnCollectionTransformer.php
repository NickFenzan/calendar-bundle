<?php

namespace EMR\Bundle\CalendarBundle\Form\DataTransformer;

use MillerVein\Component\Form\DataTransformer\AbstractCollectionTransformer;

/**
 * Description of CategoryCollectionTransformer
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnCollectionTransformer extends AbstractCollectionTransformer {
    const REVERSE_CLASS = '\EMR\Bundle\CalendarBundle\Model\Collections\ColumnCollection';
}
