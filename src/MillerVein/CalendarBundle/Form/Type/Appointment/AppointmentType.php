<?php

namespace MillerVein\CalendarBundle\Form\Type\Appointment;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
abstract class AppointmentType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        if (isset($options['action'])) {
            $builder->setAction($options['action']);
        }

        /* @var $calCol \MillerVein\CalendarBundle\Model\CalendarColumn */
        $calCol = $options['calendar_column'];
        $schedulingIncrement = $calCol->getHours()->getSchedulingIncrement();
        $builder->add('start', 'datetime',[
                    'widget' => 'single_text'
                ])
                ->add('duration', 'choice', [
                    'choices' => $this->durationChoices($schedulingIncrement)
                ])
                ->add('column', 'entity', [
                    'property' => 'name',
                    'class' => 'MillerVeinCalendarBundle:Column'
                ])
                ->add('notes', 'textarea', [
                    'required' => false
                ]);
    }

    protected function submitButtons(FormBuilderInterface $builder) {
        $builder->add('submit', 'submit');
    }

    protected function durationChoices($increment = 15) {
        $choices = array();
        for ($i = $increment; $i < 480; $i+=$increment) {
            $hoursString = ($i >= 120) ? '\h\o\u\r\s' : '\h\o\u\r';
            if ($i < 60) {
                $description = date('i \m\i\n\u\t\e\s', mktime(0, $i));
            } elseif ($i % 60 == 0) {
                $description = date('G ' . $hoursString, mktime(0, $i));
            } else {
                $description = date('G ' . $hoursString . ' i \m\i\n\u\t\e\s', mktime(0, $i));
            }


            $choices[$i] = $description;
        }
        return $choices;
    }

    public function getName() {
        return "appointment";
    }

    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setRequired('type');
        $resolver->setRequired('calendar_column');
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Appointment\Appointment'
        ));
    }

}
