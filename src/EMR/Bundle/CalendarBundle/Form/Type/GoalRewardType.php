<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class GoalRewardType extends AbstractType{
    public function getName() {
        return "new_goal_reward";
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('description','text',[
                    'required' => false,
                ])
                ->add('start_date','date',[
                    'widget' => 'single_text'
                ])
                ->add('end_date','date',[
                    'widget' => 'single_text',
                    'required' => false
                ])
                ->add('goal_threshold','number');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults([
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\GoalReward'
        ]);
    }

}
