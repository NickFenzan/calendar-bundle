<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFinderRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('category', 'entity', [
                    'class' => 'MillerVeinCalendarBundle:Category\PatientCategory',
                    'property' => 'name',
                ])
                ->add('site', 'entity', [
                    'class' => 'MillerVeinEMRBundle:Site',
                    'property' => 'city',
                ])
                ->add('min_date', 'date', [
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy'
                ])
                ->add('max_date', 'date', [
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy'
                ])
                ->add('duration', 'number')
        ;
    }

    public function getName() {
        return "appointment_finder_request";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Model\AppointmentFinderRequest',
        ));
    }

}
