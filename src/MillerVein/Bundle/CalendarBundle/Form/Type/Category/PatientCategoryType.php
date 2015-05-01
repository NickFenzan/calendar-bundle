<?php

namespace MillerVein\Bundle\CalendarBundle\Form\Type\Category;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientCategoryType extends CategoryType {


    public function getName() {
        return "category_patient";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\Bundle\CalendarBundle\Entity\Category\PatientCategory',
        ));
    }

}
