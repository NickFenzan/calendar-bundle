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
                ->add('min_duration', 'number')
                ->add('max_duration', 'number')
                ->add('default_duration', 'number')
                ->add('required_column_tags', 'entity', [
                    'property' => 'name',
                    'class' => 'MillerVeinCalendarBundle:ColumnTag',
                    'multiple' => true,
                    'required' => false
                ])
            ;
    }
}
