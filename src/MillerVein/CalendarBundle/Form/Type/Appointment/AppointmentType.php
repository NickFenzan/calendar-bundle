<?php

namespace MillerVein\CalendarBundle\Form\Type\Appointment;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
abstract class AppointmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if(isset($options['action'])){
            $builder->setAction($options['action']);
        }
        
        $builder->add('title', 'text')
                ->add('date_time', 'datetime')
                ->add('duration', 'number')
                ->add('column', 'entity',[
                    'class' => 'MillerVeinCalendarBundle:Column',
                    'property' => 'name'
                ])
            ;
    }

    public function getName() {
        return "appointment";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Appointment\Appointment',
        ));
    }

}
