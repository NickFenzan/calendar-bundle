<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

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
                    'class' => 'EMRLegacyBundle:Users',
                    'property' => 'username'
                ])
                ->add('site','entity',[
                    'class' => 'EMRLegacyBundle:Site',
                    'property' => 'city'
                ])
                ->add('provider','entity',[
                    'label' => 'Provider',
                    'class' => 'EMRLegacyBundle:Users',
                    'property' => 'username'
                ])
                ->add('hours','entity',[
                    'class' => 'EMRCalendarBundle:Hours',
                    'property' => 'name',
                    'multiple' => 'true',
                    'required' => false,
                ])
                ->add('tags','entity',[
                    'class' => 'EMRCalendarBundle:ColumnTag',
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
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\Column',
        ));
    }

}
