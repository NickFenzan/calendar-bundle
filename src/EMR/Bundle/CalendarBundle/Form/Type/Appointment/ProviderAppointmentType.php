<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Appointment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ProviderAppointmentType extends AppointmentType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder->add('category', 'entity', [
                    'class' => 'MillerVeinCalendarBundle:Category\ProviderCategory',
                    'property' => 'name'
                ]);
//                ->add('recurrence_rule', 'entity', [
//                    'label' => 'Repeats',
//                    'required' => false,
//                    'class' => 'MillerVeinCalendarBundle:RecurrenceRule',
//                    'property' => 'name'
//                ]);
        $this->submitButtons($builder);
    }

    public function getName() {
        return "appointment_provider";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\Appointment\ProviderAppointment',
        ));
    }

}
