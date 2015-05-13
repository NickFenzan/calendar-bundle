<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use EMR\Bundle\CalendarBundle\Form\DataTransformer\ColumnCollectionTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ColumnType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if($options['multiple']){
            $builder->addModelTransformer(new ColumnCollectionTransformer());
        }
    }
    
    public function getParent() {
        return 'entity';
    }
    
    public function getName() {
        return "column";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'class' => 'EMR\Bundle\CalendarBundle\Entity\Column',
            'property' => 'longName',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                        ->addSelect('s')
                        ->join('c.site', 's');
            },
        ));
    }
}
