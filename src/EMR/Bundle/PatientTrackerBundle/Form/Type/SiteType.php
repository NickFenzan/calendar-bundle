<?php

namespace EMR\Bundle\PatientTrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class SiteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('site','entity',[
                    'class' => 'EMRLegacyBundle:Site',
                    'property' => 'city'
                ])
        ;
    }

    public function getName() {
        return "site";
    }
}
