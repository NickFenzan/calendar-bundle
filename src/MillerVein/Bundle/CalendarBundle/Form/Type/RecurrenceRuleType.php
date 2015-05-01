<?php

namespace MillerVein\Bundle\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MillerVein\Bundle\CalendarBundle\Entity\RecurrenceRule;

/**
 * Description of ColumnType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RecurrenceRuleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', 'text')
                ->add('freq', 'choice', array(
                    'label' => 'Repeats',
                    'choices' => RecurrenceRule::getFreqChoices()
//                    'choices' => $this->getFrequencies()
                ))
                ->add('interval', 'number', array(
                    'label' => 'Every',
                ))
                ->add('endMethod', 'choice', array(
                    'label' => 'Until',
                    'choices' => array(
                        'until' => 'A Certain Date',
                        'count' => 'A Certain Number of Times',
                        'forever' => 'Forever'
                    ),
                    'mapped' => false
                ))
                ->add('until', 'date', array(
                    'label' => 'End Date',
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                    'required' => false
                ))
                ->add('count', 'number', array(
                    'required' => false
                ))
                ->add('byDay', 'hidden', array(
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
                ))
                ->add('byMonth', 'hidden', array(
                    'label' => ' ',
                    'required' => false,
                ))
                ->add('byMonthChoice', 'choice', array(
                    'choices' => $this->getMonths(),
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'By Month',
                    'required' => false,
                    'mapped' => false
                ))
//                ->add('byWeekNo', 'text', array(
//                    'label' => 'By Week Number',
//                    'required' => false
//                ))
//                ->add('byYearDay', 'text', array(
//                    'label' => 'By Day of Year',
//                    'required' => false
//                ))
        ;
    }

    protected function getFrequencies() {
        $refl = new \ReflectionClass('MillerVein\Bundle\CalendarBundle\Entity\RecurrenceRule');
        $array = array();
        foreach ($refl->getConstants() as $constant => $value) {
            if (preg_match("/^FREQ/", $constant)) {
                $array[$value] = ucfirst(strtolower($value));
            }
        }
        return $array;
    }

    protected function getDaysOfWeek() {
        $refl = new \ReflectionClass('MillerVein\Bundle\CalendarBundle\Entity\RecurrenceRule');
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

    protected function getMonths() {
        $array = array();
        for ($i = 1; $i <= 12; $i++) {
            $dateObj = \DateTime::createFromFormat('!m', $i);
            $array[$i] = $dateObj->format('M');
        }
        return $array;
    }

    public function getName() {
        return "recurrence_rule";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\Bundle\CalendarBundle\Entity\RecurrenceRule',
        ));
    }

}
