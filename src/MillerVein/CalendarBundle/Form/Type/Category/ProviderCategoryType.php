<?php

namespace MillerVein\CalendarBundle\Form\Type\Category;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ProviderCategoryType extends CategoryType {


    public function getName() {
        return "category_provider";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Category\ProviderCategory',
        ));
    }

}
