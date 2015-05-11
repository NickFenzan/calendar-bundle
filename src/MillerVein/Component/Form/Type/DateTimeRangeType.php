<?php

namespace MillerVein\Component\Form\Type;

use MillerVein\Component\Form\DataTransformer\DateRangeToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of DateTimeRangeType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DateTimeRangeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $controlOptions = $options;
        switch($options['mode']){
            case 'date':
                $controlOptions = array_intersect_key($options, array_flip(array(
                    'required',
                    'format',
                    'widget'
                )));
                break;
            case 'time':
                $controlOptions = array_intersect_key($options, array_flip(array(
                    'required',
                    'widget'
                )));
                break;
            case 'datetime':
            default:
                $controlOptions = array_intersect_key($options, array_flip(array(
                    'required',
                    'widget',
                    'date_widget',
                    'time_widget'
                )));
        }
        $builder->add('start', $options['mode'], $controlOptions)
                ->add('end', $options['mode'], $controlOptions);
        $transformer = new DateRangeToArrayTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $widget = function(Options $options) {
            if ($options['mode'] === 'date') {
                return 'single_text';
            } elseif ($options['mode'] === 'time') {
                return 'choice';
            }
        };
        $dateWidget = function (Options $options) {
            if (null === $options['widget']) {
                return 'single_text';
            } else {
                return $options['widget'];
            }
        };

        // Defaults to the value of "widget"
        $timeWidget = function (Options $options) {
            return $options['widget'];
        };
        
        $dateFormat = function(Options $options){
            if ($options['mode'] === 'date') {
                return 'MM/dd/yyyy';
            }else{
                return null;
            }
        };

        $resolver->setDefaults([
            'mode' => 'datetime',
            'widget' => $widget,
            'date_widget' => $dateWidget,
            'time_widget' => $timeWidget,
            'format' => $dateFormat
        ]);

        $resolver->setAllowedValues([
            'mode' => [
                'datetime',
                'date',
                'time'
            ],
        ]);
    }

    public function getName() {
        return 'datetime_range';
    }

}
