<?php

namespace MillerVein\Bundle\CalendarBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of PatientToNumberTransformer
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientIDToNameTransformer implements DataTransformerInterface {

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
     * Transforms an string (patient id) to a string (patient name).
     *
     * @param  string $id
     * @return string
     * @throws TransformationFailedException if object (patient) is not found.
     */
    public function transform($id) {
        if ("" === $id) {
            return "";
        }

        /* @var $patient \MillerVein\Bundle\CalendarBundle\Entity\Patient  */
        $patient = $this->om
            ->getRepository('MillerVeinEMRBundle:PatientData')
            ->find($id);

        if (null === $patient) {
            throw new TransformationFailedException(sprintf(
                'A patient with the id "%s" does not exist!',
                $id
            ));
        }
        
        $displayFormat = '%1$s, %2$s (%3$d)';
//        $displayFormat = '(%3$d) %2$s %1$s';
        
        $displayString = sprintf($displayFormat,
            $patient->getLname(),
            $patient->getFname(),
            $patient->getPid()
        );
        
        return $displayString;
    }

    /**
     * Transforms a string (patient name) to a string (patient id).
     *
     * @param  string $id
     * @return string
     */
    public function reverseTransform($string) {
        $matches=array();
        preg_match("/\((\d+)\)/", $string,$matches);
        if (!isset($matches[1])) {
            return "";
        }

        return $matches[1];
    }

}
