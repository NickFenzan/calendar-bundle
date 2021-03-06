<?php

namespace EMR\Bundle\CalendarBundle\Form\Type\Appointment;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use EMR\Bundle\CalendarBundle\Model\CalendarColumn;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientAppointmentType extends AppointmentType {

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        $repo = $this->em->getRepository('EMRCalendarBundle:Category\PatientCategory');

        /* @var $calCol CalendarColumn */
        $calCol = $options['calendar_column'];
        $categoryChoices = $repo->findAllowedByTags($calCol->getColumn()->getTags());

        $builder->add('category', 'entity', [
                    'class' => 'EMRCalendarBundle:Category\PatientCategory',
                    'property' => 'name',
                    'choices' => $categoryChoices
                ])
                ->add('status', 'entity', [
                    'property' => 'name',
                    'class' => 'EMRCalendarBundle:AppointmentStatus',
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
            'data_class' => 'EMR\Bundle\CalendarBundle\Entity\Appointment\PatientAppointment',
        ));
    }

}
