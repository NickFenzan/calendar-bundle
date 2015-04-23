<?php

namespace MillerVein\CalendarBundle\Form\Type;

use DateInterval;
use DateTime;
use Doctrine\ORM\EntityRepository;
use MillerVein\CalendarBundle\Form\DataTransformer\TimeStringToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentFinderRequestType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $today = new DateTime();
        $nextMonth = clone $today;
        $nextMonth->add(new DateInterval('P1Y'));
        $builder
                ->add('category', 'entity', [
                    'class' => 'MillerVeinCalendarBundle:Category\PatientCategory',
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                ->orderBy('c.name', 'ASC');
                    },
                    'property' => 'name',
                ])
                ->add('site', 'entity', [
                    'class' => 'MillerVeinEMRBundle:Site',
                    'property' => 'city',
                ])
                ->add('min_date', 'date', [
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                    'data' => $today
                ])
                ->add('max_date', 'date', [
                    'widget' => 'single_text',
                    'format' => 'MM/dd/yyyy',
                    'data' => $nextMonth
                ])
                ->add(
                        $builder->create('min_time', 'choice', [
                            'required' => false,
                            'choices' => $this->times()
                        ])->addModelTransformer(new TimeStringToDateTimeTransformer())
                )
                ->add(
                        $builder->create('max_time', 'choice', [
                            'required' => false,
                            'choices' => $this->times()
                        ])->addModelTransformer(new TimeStringToDateTimeTransformer())
                )
                ->add('day_of_week', 'choice', [
                    'required' => false,
                    'label' => 'Day of Week',
                    'choices' => $this->daysOfWeek()
                ])
                ->add('duration', 'number', ['data' => 15])
        ;
    }

    protected function daysOfWeek() {
        return [7 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday', 4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday'];
    }

    protected function times() {
        $times = array();
        for ($time = new DateTime('7:00'); $time->format('H:i') <= '21:00'; $time->add(new DateInterval('PT15M'))) {
            $times[$time->format('H:i')] = $time->format('g:i a');
        }
        return $times;
    }

    public function getName() {
        return "appointment_finder_request";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Model\AppointmentFinderRequest',
        ));
    }

}
