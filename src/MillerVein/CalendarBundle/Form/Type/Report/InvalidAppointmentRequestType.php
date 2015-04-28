<?php

namespace MillerVein\CalendarBundle\Form\Type\Report;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
/**
 * Description of InvalidAppointmentReportType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class InvalidAppointmentRequestType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('start_date', 'date')
                ->add('end_date', 'date')
//                ->add('sites', 'entity', [
//                    'required' => false,
//                    'multiple' => true,
//                    'class' => 'MillerVeinEMRBundle:Site',
//                    'property' => 'city',
//                ])
//                ->add('outside_of_hours', 'checkbox', [
//                    'required' => false,
//                ])
//                ->add('overlapping_appointments', 'checkbox', [
//                    'required' => false,
//                ])
                ;
    }
    public function getName() {
        return 'invalid_appointment';
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Model\Reports\InvalidAppointment\InvalidAppointmentRequest',
        ));
    }
}
