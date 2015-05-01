<?php

namespace MillerVein\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of CalendarRequestType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CalendarRequestType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if (isset($options['action'])) {
            $builder->setAction($options['action']);
        }

        $builder->add('date', 'date', [
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
        ;
    }

    public function getName() {
        return "calendar_request";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\Bundle\CalendarBundle\Model\CalendarRequest',
        ));
    }

}
