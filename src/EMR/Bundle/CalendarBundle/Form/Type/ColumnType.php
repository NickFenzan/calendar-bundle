<?php

namespace EMR\Bundle\CalendarBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnType extends AbstractType {
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
