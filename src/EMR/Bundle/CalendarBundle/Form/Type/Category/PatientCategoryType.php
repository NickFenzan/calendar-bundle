<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Category;

use Doctrine\ORM\EntityRepository;
use EMR\Bundle\CalendarBundle\Form\DataTransformer\CategoryCollectionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientCategoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        if($options['multiple']){
            $builder->addModelTransformer(new CategoryCollectionTransformer());
        }
    }
    
    public function getParent() {
        return "entity";
    }

    public function getName() {
        return "category_patient";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'class' => 'EMR\Bundle\CalendarBundle\Entity\Category\PatientCategory',
            'property' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                        ->orderBy('c.name');
            }
        ));
    }

}
