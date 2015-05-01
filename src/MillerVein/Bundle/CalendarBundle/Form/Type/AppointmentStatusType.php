<?php

namespace MillerVein\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentStatusType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text')
            ->add('legacy_id', 'text', [
                'label' => 'Legacy ID',
                'required' => false,
                'attr' => ['maxlength'=>1]
            ])
            ->add('cancelled', 'checkbox', [
                'required' => false,
                'label' => 'Cancelled Status',
            ])
            ->add('auto_create_encounter', 'checkbox', [
                'required' => false,
                'label' => 'Auto-create Encounters',
            ]);
    }

    public function getName() {
        return "appointment_status";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\Bundle\CalendarBundle\Entity\AppointmentStatus',
        ));
    }

}
