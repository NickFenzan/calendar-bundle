<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Report;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoalType extends AbstractType {

    public function getName() {
        return "new_utilization_goal";
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('start_date', 'date', [
                    'widget' => 'single_text'
                ])
                ->add('end_date', 'date', [
                    'widget' => 'single_text',
                    'required' => false
                ])
                ->add('goal', 'text')
                ->add('metric','entity',[
                    'class' => 'EMRCalendarBundle:UtilizationMetric',
                    'property' => 'name',
                ])
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\UtilizationGoal'
        ]);
    }

}
