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
                ->add('start_date', 'date',[
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                ])
                ->add('open_time', 'time')
                ->add('close_time', 'time')
                ->add('scheduling_increment', 'number')
                ->add('recurrence_rule', 'entity', array(
                    'required' => false,
                    'class' => 'MillerVeinCalendarBundle:RecurrenceRule',
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
