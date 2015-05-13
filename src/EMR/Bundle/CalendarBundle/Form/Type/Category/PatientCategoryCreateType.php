<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Category;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientCategoryCreateType extends CategoryType {


    public function getName() {
        return "category_patient_create";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\Category\PatientCategory',
        ));
    }

}
