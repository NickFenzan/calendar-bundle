<?php

namespace MillerVein\CalendarBundle\Form\Type\Category;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
abstract class CategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if(isset($options['action'])){
            $builder->setAction($options['action']);
        }
        
        $builder->add('name', 'text')
                ->add('color', 'color')
                ->add('default_duration', 'number')
            ;
    }
}
