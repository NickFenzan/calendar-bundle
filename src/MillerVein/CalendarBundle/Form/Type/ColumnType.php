<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text')
                ->add('site','entity',[
                    'class' => 'MillerVeinCalendarBundle:Site',
                    'property' => 'city'
                ])
                ->add('hours','entity',[
                    'class' => 'MillerVeinCalendarBundle:Hours',
                    'property' => 'name',
                    'multiple' => 'true'
                ])
        ;
    }

    public function getName() {
        return "column";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Column',
        ));
    }

}
