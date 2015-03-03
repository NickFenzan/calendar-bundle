<?php

namespace MillerVein\CalendarBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use MillerVein\CalendarBundle\Entity\RecurranceRule;

/**
 * Description of ColumnType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RecurranceRuleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('freq', 'choice', array(
                    'label' => 'Repeats',
                    'choices' => RecurranceRule::getFreqChoices()
//                    'choices' => $this->getFrequencies()
                ))
                ->add('interval', 'number', array(
                    'label' => 'Every',
                ))
                ->add('endMethod','choice',array(
                    'label' => 'Until',
                    'choices' => array(
                        'until' => 'A Certain Date',
                        'count' => 'A Certain Number of Times',
                        'forever' => 'Forever'
                        ),
                    'mapped' =>false
                ))
                ->add('until', 'date', array(
                    'label' => 'End Date',
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                    'required' => false
                ))
                ->add('count', 'number',array(
                    'required' => false
                ))
                ->add('byDay', new ByDayType(), array(
                    'label' => 'By Day',
                    'required' => false
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
                ->add('byWeekNo', 'text', array(
                    'label' => 'By Week Number',
                    'required' => false
                ))
                ->add('byYearDay', 'text', array(
                    'label' => 'By Day of Year',
                    'required' => false
                ))
                ->add('byMonthDay', 'text', array(
                    'label' => 'By Day of Month',
                    'required' => false
                ))
        ;
    }
    
    protected function getFrequencies() {
        $refl = new \ReflectionClass('MillerVein\CalendarBundle\Entity\RecurranceRule');
        $array = array();
        foreach ($refl->getConstants() as $constant => $value) {
            if (preg_match("/^FREQ/", $constant)) {
                $array[$value] = ucfirst(strtolower($value));
            }
        }
        return $array;
    }

//    protected function getDaysOfWeek() {
//        $refl = new \ReflectionClass('MillerVein\CalendarBundle\Entity\RecurranceRule');
//        $array = array();
//        foreach ($refl->getConstants() as $constant => $value) {
//            $matches = array();
//            if (preg_match("/^WEEKDAY_([A-Z]+)$/", $constant, $matches)) {
//                $array[$value] = ucfirst(strtolower($matches[1]));
//            }
//        }
//        return $array;
//    }
    
    protected function getMonths() {
        $array = array();
        for ($i = 1; $i <= 12; $i++) {
            $dateObj = \DateTime::createFromFormat('!m', $i);
            $array[$i] = $dateObj->format('M');
        }
        return $array;
    }

    public function getName() {
        return "recurrance_rule";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\RecurranceRule',
        ));
    }

}
