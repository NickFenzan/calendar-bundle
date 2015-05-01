<?php

namespace MillerVein\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text')
                ->add('legacy_provider','entity',[
                    'label' => 'Legacy Provider',
                    'class' => 'MillerVeinEMRBundle:Users',
                    'property' => 'username'
                ])
                ->add('site','entity',[
                    'class' => 'MillerVeinEMRBundle:Site',
                    'property' => 'city'
                ])
                ->add('provider','entity',[
                    'label' => 'Provider',
                    'class' => 'MillerVeinEMRBundle:Users',
                    'property' => 'username'
                ])
                ->add('hours','entity',[
                    'class' => 'MillerVeinCalendarBundle:Hours',
                    'property' => 'name',
                    'multiple' => 'true',
                    'required' => false,
                ])
                ->add('tags','entity',[
                    'class' => 'MillerVeinCalendarBundle:ColumnTag',
                    'property' => 'name',
                    'multiple' => 'true',
                    'required' => false,
                ])
        ;
    }

    public function getName() {
        return "column";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\Bundle\CalendarBundle\Entity\Column',
        ));
    }

}
