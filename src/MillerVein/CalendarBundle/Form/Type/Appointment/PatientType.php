<?php

namespace MillerVein\CalendarBundle\Form\Type\Appointment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientType extends AppointmentType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder->add('patient','entity',[
            'class' => 'MillerVeinCalendarBundle:Patient',
            'property' => 'lname'
        ]);
        
        $this->submitButtons($builder);
    }

        public function getName() {
        return "appointment_patient";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Appointment\Patient',
        ));
    }

}
