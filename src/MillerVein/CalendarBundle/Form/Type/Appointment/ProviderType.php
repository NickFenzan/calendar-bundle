<?php

namespace MillerVein\CalendarBundle\Form\Type\Appointment;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ProviderType extends AppointmentType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        $builder->add('category', 'entity', [
                    'class' => 'MillerVeinCalendarBundle:Category\Provider',
                    'property' => 'name'
                ]);
        $this->submitButtons($builder);
    }

    public function getName() {
        return "appointment_provider";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Appointment\Provider',
        ));
    }

}
