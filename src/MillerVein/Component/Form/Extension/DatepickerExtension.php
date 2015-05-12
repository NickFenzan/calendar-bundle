<?php

namespace MillerVein\Component\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of DatepickerExtension
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class DatepickerExtension extends AbstractTypeExtension{

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(['format'=>'MM/dd/yyyy']);
    }

    
    public function buildView(FormView $view, FormInterface $form, array $options) {
//        print_r($view->vars);
        if ($options['widget'] === 'single_text') {
            $view->vars['attr']['data-hasdatepicker'] = 'true';
        }else{
            $view->vars['attr']['data-hasdatepicker'] = 'false';
        }
    }

    public function getExtendedType() {
        return 'date';
    }
}
