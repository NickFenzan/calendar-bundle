<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Report;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationMetricType extends AbstractType{
    public function getName() {
        return 'new_utilization_metric';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name','text')
                ->add('tags','column_tag',[
                    'multiple' => true,
                    'required' => false,
                ])
                ->add('columns','column',[
                    'multiple' => true,
                    'required' => false,
                ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\UtilizationMetric'
        ]);
    }

}
