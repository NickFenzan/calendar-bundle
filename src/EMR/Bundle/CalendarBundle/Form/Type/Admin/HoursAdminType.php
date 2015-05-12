<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Admin;

use Doctrine\ORM\EntityRepository;
use MillerVein\Component\DateTime\DateTimeRange;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Description of HoursAdminType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursAdminType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $nullTimeRange = new DateTimeRange();
        $nullTimeRange->setNullValid(true);
        $builder->add('columns', 'entity', [
                    'multiple' => true,
                    'class' => 'EMR\Bundle\CalendarBundle\Entity\Column',
                    'property' => 'longName',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                ->addSelect('s')
                                ->join('c.site', 's');
                    },
                    'required' => false
                ])
                ->add('start_date', 'datetime_range', [
                    'mode' => 'date',
                    'required' => false,
                ])
                ->add('end_date', 'datetime_range', [
                    'mode' => 'date',
                    'required' => false,
                    'data' => $nullTimeRange
                ])
                ->add('open_time', 'datetime_range', [
                    'mode' => 'time',
                    'required' => false
                ])
                ->add('lunch_start', 'datetime_range', [
                    'mode' => 'time',
                    'required' => false
                ])
                ->add('lunch_end', 'datetime_range', [
                    'mode' => 'time',
                    'required' => false
                ])
                ->add('close_time', 'datetime_range', [
                    'mode' => 'time',
                    'required' => false
                ])
        ;
    }

    public function getName() {
        return 'hours_admin';
    }

}