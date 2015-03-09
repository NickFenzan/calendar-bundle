<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ByDayType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text')
                ->add('open_time', 'time')
                ->add('close_time', 'time')
                ->add('lunch_start', 'time')
                ->add('lunch_end', 'time')
                ->add('scheduling_increment', 'number')
                ->add('recurrance_rule', 'entity', array(
                    'required' => false,
                    'class' => 'MillerVeinCalendarBundle:RecurranceRule',
                    'property' => 'name'
        ));
    }

    public function getName() {
        return "hours";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Hours',
        ));
    }

}
