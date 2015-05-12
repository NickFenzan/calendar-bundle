<?php

namespace EMR\Bundle\CalendarBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of FormController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientSelectorController extends Controller{
    /**
     * @Route("/patient/patient_selector", name="patient_selector", options={"expose"=true})
     * @Method({"GET"})
     */
    public function patientSelectorAction(Request $request) {
        $searchTerm = $request->get('term');
        if (strlen($searchTerm)<2){
            return new JsonResponse();
        }
        
        $patRepo = $this->getDoctrine()->getManager()->getRepository("EMRLegacyBundle:PatientData");
        /* @var $patRepo \EMR\Bundle\LegacyBundle\Entity\Repository\PatientDataRepository */
        $patients = $patRepo->findAllBySearchTerm($searchTerm);

        $patientResponse = array();
        foreach($patients as $patient){
            /* @var $patient \EMR\Bundle\LegacyBundle\Entity\PatientData */
            $displayFormat = '%1$s, %2$s (%3$d)';
//        $displayFormat = '(%3$d) %2$s %1$s';
            $patientResponse[] = sprintf($displayFormat,
                    $patient->getLname(),
                    $patient->getFname(),
                    $patient->getPid());
        }
            
        return new JsonResponse($patientResponse);
    }
}
