<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of ByDayType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ByDayType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('byDay', 'hidden', array(
                    'label' => 'By Day',
                    'required' => false,
                ))
                ->add('byDayChoice', 'choice', array(
                    'label' => 'By Day',
                    'choices' => $this->getDaysOfWeek(),
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'mapped' => false
                ))
                ->add('byDayPositiveRelative', 'choice', array(
                    'label' => 'By Day Relative Positive',
                    'choices' => $this->getRelativePositive(),
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'mapped' => false
                ))
                ->add('byDayNegativeRelative', 'choice', array(
                    'label' => 'By Day Relative Positive',
                    'choices' => $this->getRelativeNegative(),
                    'multiple' => true,
                    'expanded' => true,
                    'required' => false,
                    'mapped' => false
        ));
    }

    protected function getDaysOfWeek() {
        $refl = new \ReflectionClass('MillerVein\CalendarBundle\Entity\RecurranceRule');
        $array = array();
        foreach ($refl->getConstants() as $constant => $value) {
            $matches = array();
            if (preg_match("/^WEEKDAY_([A-Z]+)$/", $constant, $matches)) {
                $array[$value] = ucfirst(strtolower($matches[1]));
            }
        }
        return $array;
    }

    protected function getRelativePositive() {
        $daysOfWeek = $this->getDaysOfWeek();
        $array = array();
        for ($i = 1; $i <= 5; $i++) {
            foreach ($daysOfWeek as $val => $name) {
                $array["+$i$val"] = " ";
            }
        }
        return $array;
    }
    protected function getRelativeNegative() {
        $daysOfWeek = $this->getDaysOfWeek();
        $array = array();
        for ($i = 5; $i >= 1; $i--) {
            foreach ($daysOfWeek as $val => $name) {
                $array["-$i$val"] = " ";
            }
        }
        return $array;
    }

    public function getName() {
        return "by_day";
    }

}
