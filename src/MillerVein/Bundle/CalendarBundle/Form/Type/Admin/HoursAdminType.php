<?php
namespace MillerVein\Bundle\CalendarBundle\Form\Type\Admin;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
/**
 * Description of HoursAdminType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursAdminType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('columns','entity',[
            'multiple' => true,
            'class' => 'MillerVein\Bundle\CalendarBundle\Entity\Column',
            'property' => 'longName'
        ]);
    }

    public function getName() {
        return 'hours_admin';
    }
}
