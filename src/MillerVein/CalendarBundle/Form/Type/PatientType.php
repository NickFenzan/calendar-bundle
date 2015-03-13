<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fname', 'text')
                ->add('lname', 'text')
                ->add('dob', 'date', [
                    'widget' => 'single_text'
                ]);
    }

    public function getName() {
        return "patient";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Patient',
        ));
    }

}
