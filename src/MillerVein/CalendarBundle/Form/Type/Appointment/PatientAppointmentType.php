<?php

namespace MillerVein\CalendarBundle\Form\Type\Appointment;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MillerVein\CalendarBundle\Model\CalendarColumn;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientAppointmentType extends AppointmentType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        /* @var $calCol CalendarColumn */
        $calCol = $options['calendar_column'];

        $builder->add('category', 'entity', [
                    'class' => 'MillerVeinCalendarBundle:Category\PatientCategory',
                    'property' => 'name',
                    'choices' =>
                    function(EntityRepository $er) {
                return $er->findAllowedByTags($calCol->getColumn()->getTags());
            },
                ])
                    ->add('leg', 'choice', [
                        'required' => false,
                        'choices' => [
                            'left' => 'Left',
                            'right' => 'Right',
                            'bilateral' => 'Bilateral'
                        ]
                ])
                ->add('status', 'entity', [
                    'property' => 'name',
                    'class' => 'MillerVeinCalendarBundle:AppointmentStatus',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('a')
                        ->orderBy('a.display_position', 'ASC');
            },
                ])
                ->add('patient', 'patient_selector');

        $this->submitButtons($builder);
    }

    public function getName() {
        return "appointment_patient";
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => 'MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment',
        ));
    }

}
