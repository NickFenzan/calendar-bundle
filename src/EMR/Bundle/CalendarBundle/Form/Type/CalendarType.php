<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CalendarType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if(isset($options['action'])){
            $builder->setAction($options['action']);
        }
        
        $builder->add('date', 'date', [
                    'attr' => ['style' => 'display:none;'],
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy'
                    ])
                ->add('site', 'entity', [
                    'class' => 'MillerVeinEMRBundle:Site',
                    'property' => 'city',
                ])
                ->add('show_cancelled', 'checkbox', [
                    'label' => 'Show Cancelled',
                    'required' => false
                ])
                ->add('previous', 'submit',
                        ['label' => '<<'])
                ->add('next', 'submit',
                        ['label' => '>>'])
            ;
    }

    public function getName() {
        return "calendar";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'EMR\Bundle\CalendarBundle\Model\Calendar',
        ));
    }

}
