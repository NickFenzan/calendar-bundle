<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ColumnTagType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnTagType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
    }
    
    public function getParent() {
        return 'entity';
    }
    
    public function getName() {
        return "column_tag";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'class' => 'EMR\Bundle\CalendarBundle\Entity\ColumnTag',
            'property' => 'name',
        ));
    }
}