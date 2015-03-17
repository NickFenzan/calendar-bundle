<?php

namespace MillerVein\CalendarBundle\Form\Type\Appointment;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
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

    public function __construct(EntityManager $em ) {
        $this->em = $em;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);

        /* @var $calCol \MillerVein\CalendarBundle\Model\CalendarColumn */
        $calCol = $options['calendar_column'];
        
        $repo = $this->em->getRepository('MillerVeinCalendarBundle:Category\PatientCategory');
        $categoryChoices = $repo->findAllowedByTags($calCol->getColumn()->getTags());
        
        $builder->add('category', 'entity', [
                    'class' => 'MillerVeinCalendarBundle:Category\PatientCategory',
                    'property' => 'name',
                    'choices' => $categoryChoices
                ])
                ->add('patient','patient_selector');

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
