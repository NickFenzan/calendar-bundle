<?php

namespace MillerVein\Bundle\CalendarBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use MillerVein\Bundle\CalendarBundle\Form\DataTransformer\PatientIDToNameTransformer;
use MillerVein\Bundle\CalendarBundle\Form\DataTransformer\PatientToNumberTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Description of PatientSelectorType
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientSelectorType extends AbstractType{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $modelTransformer = new PatientToNumberTransformer($this->om);
        $viewTransformer = new PatientIDToNameTransformer($this->om);
        $options['attr'] = ['class'=>'patient_selector'];
        $builder->addModelTransformer($modelTransformer);
        $builder->addViewTransformer($viewTransformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected patient does not exist',
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'patient_selector';
    }
}
