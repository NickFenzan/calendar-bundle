<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

use MillerVein\Component\DateTime\DateTimeRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of AppointmentMoverType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentMoverType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $start = new \DateTime('8:00');
        $end = new \DateTime('17:00');
        $defaultRange = new DateTimeRange($start,$end);
        $builder->add('from_columns', 'column', [
                    'multiple' => true
                ])
                ->add('to_column', 'column')
                ->add('date_range', 'datetime_range',[
                    'nullable' => false,
                    'data' => $defaultRange
                ])
                ->add('categories', 'category_patient',[
                    'multiple' => true,
                    'required' => false
                ]);
        
    }

    public function getName() {
        return 'appointment_mover';
    }

}
