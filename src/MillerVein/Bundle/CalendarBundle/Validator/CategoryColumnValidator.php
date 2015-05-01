<?php

namespace MillerVein\Bundle\CalendarBundle\Validator;

use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraint;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CategoryColumnValidator extends ConstraintValidator {

    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function validate($object, Constraint $constraint) {
        /* @var $object \MillerVein\Bundle\CalendarBundle\Entity\Appointment\Appointment */
        $category = $object->getCategory();
        $column = $object->getColumn();
        $columnTagIds = array();
        foreach($column->getTags() as $tag){
            $columnTagIds[] = $tag->getId();
        }
        $categoryTagIds = array();
        foreach($category->getRequiredColumnTags() as $tag){
            $categoryTagIds[] = $tag->getId();
        }
        
        $intersect = array_intersect($categoryTagIds, $columnTagIds);
        if(empty($intersect)){
            $this->context->addViolation('This category is not valid for this category.');
        }
    }

}