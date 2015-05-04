<?php

namespace MillerVein\Component\Form\Type;

use MillerVein\Component\Form\DataTransformer\DateRangeToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of DateTimeRangeType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateTimeRangeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('start','datetime',[
            'date_widget' => 'single_text',
            'time_widget' => 'single_text'
        ])
                ->add('end','datetime');
        $transformer = new DateRangeToArrayTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) { 
    }

    public function getName() {
        return 'datetime_range';
    }

}
