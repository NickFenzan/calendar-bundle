<?php

namespace MillerVein\CalendarBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use MillerVein\CalendarBundle\Entity\Patient;

/**
 * Description of PatientToNumberTransformer
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientToNumberTransformer implements DataTransformerInterface {

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }

    /**
     * Transforms an object (patient) to a string (number).
     *
     * @param  Patient|null $patient
     * @return string
     */
    public function transform($patient) {
        if (null === $patient) {
            return "";
        }

        return $patient->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $id
     *
     * @return Patient|null
     *
     * @throws TransformationFailedException if object (patient) is not found.
     */
    public function reverseTransform($id) {
        if (!$id) {
            return null;
        }

        $patient = $this->om
            ->getRepository('MillerVeinCalendarBundle:Patient')
            ->find($id);
        

        if (null === $patient) {
            throw new TransformationFailedException(sprintf(
                'A patient with the id "%s" does not exist!',
                $id
            ));
        }

        return $patient;
    }

}
