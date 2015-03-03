<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ByDayType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name', 'text');
    }

    public function getName() {
        return "hours";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Hours',
        ));
    }

}
