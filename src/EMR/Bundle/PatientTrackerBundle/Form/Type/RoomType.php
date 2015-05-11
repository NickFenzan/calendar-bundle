<?php

namespace EMR\Bundle\PatientTrackerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RoomType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('site','entity',[
                    'class' => 'EMRLegacyBundle:Site',
                    'property' => 'city'
                ])
        ;
    }

    public function getName() {
        return "room";
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'EMR\Bundle\PatientTrackerBundle\Entity\Room',
        ));
    }
}
