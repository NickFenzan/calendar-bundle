<?php

namespace MillerVein\Component\Form\Extension;

use MillerVein\Component\Form\DataTransformer\TwentyFourToTwelveHourArray;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TwelveHourTimeExtension extends AbstractTypeExtension {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('ampm', 'choice', [
            'choices' => ['AM'=>'AM', 'PM'=>'PM']
        ]);
        $builder->addViewTransformer(new TwentyFourToTwelveHourArray());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'hours' => range(1, 12)
                )
        );
    }

    public function getExtendedType() {
        return "time";
    }

}
