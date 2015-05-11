<?php

namespace EMR\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 * @Annotation
 */
class CategoryColumn extends Constraint {

    public function validatedBy() {
        return 'category_column';
    }

    
    public function getTargets() {
        return self::CLASS_CONSTRAINT;
    }
}
