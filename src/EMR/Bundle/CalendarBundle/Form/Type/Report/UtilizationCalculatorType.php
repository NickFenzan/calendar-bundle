<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Report;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationCalculatorType extends AbstractType{
    public function getName() {
        return 'utilization_calculator';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('tags','column_tag',[
                    'multiple' => true,
                    'required' => false
                ])
                ->add('columns','column',[
                    'multiple' => true,
                    'required' => false
                ])
                ->add('start_date','date',[
                    'data' => new \DateTime()
                ])
                ->add('end_date','date',[
                    'data' => new \DateTime()
                ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => 'EMR\Bundle\CalendarBundle\Model\Reports\UtilizationCalculator'
        ]);
    }

}
