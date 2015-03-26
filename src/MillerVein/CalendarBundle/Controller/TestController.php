<?php

namespace MillerVein\CalendarBundle\Controller;

use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of TestController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TestController extends Controller {

    /**
     * @Route("/test", name="apptImport")
     */
    public function testAction() {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $columnRepo = $em->getRepository("MillerVeinCalendarBundle:Column");
        $categoryRepo = $em->getRepository("MillerVeinCalendarBundle:Category\PatientCategory");
        $apptStatusRepo = $em->getRepository("MillerVeinCalendarBundle:AppointmentStatus");
        $patientRepo = $em->getRepository("MillerVeinEMRBundle:PatientData");

        $userToColumnMap = [
            10 => 1,
            28 => 2,
            16 => 3,
        ];

        $categoryMap = [
            10 => 1, //New Pat
            61 => 7, //EVTA
            62 => 8, //EVTA MP
            63 => 9, //MP
            64 => 10, //EVCA
            96 => 4, //Free US Screening
            66 => 2, //VeinErase Legs
            67 => 3, //VeinErase Face
            68 => 14, //Office Visit
            93 => 14, //Misc Billing
            75 => 14, //Ultrasound
            70 => 6, //One Week
            71 => 5, //One Year Follow Up
            73 => 5, //Six Month Follow Up
            72 => 5, //Three Month Follow Up
            94 => 11, //Three Month Follow Up
            95 => 12, //Medical Sclero
            92 => 4, //Free Vein Evaluation
            97 => 1, //Long Term New Patient
            98 => 4, //CoverDerm Screening
            50 => 14, //EMRgence Transfer
            99 => 2, //VeinErase Area
            100 => 4, //VeinErase Short Term Follow Up
            103 => 2, //VeinErase Legs - Summer Special $150
            104 => 2, //VeinErase Legs - Free Follow Up Special
            102 => 13, //Incision and Drainage
        ];

        $maxAppt = $db->fetchColumn('SELECT MAX(id) FROM calendar.appointment');
        if(!$maxAppt){
            $maxAppt = 0;
        }
        $workingAppts = $db->fetchAll('SELECT * FROM openemr.openemr_postcalendar_events e '
                . ' JOIN openemr.openemr_postcalendar_categories c '
                . ' ON e.pc_catid = c.pc_catid '
                . ' WHERE pc_eid > ? '
                . ' AND c.pc_cattype = 0 '
                . ' ORDER BY pc_eid ASC LIMIT 1000', array($maxAppt));

        if ($workingAppts) {

            foreach ($workingAppts as $oldAppt) {
                $newAppt = new PatientAppointment();

                $newAppt->setId($oldAppt['pc_eid']);
                
                // <editor-fold defaultstate="collapsed" desc="Column">
                if (array_key_exists($oldAppt['pc_aid'], $userToColumnMap)) {
                    $column = $columnRepo->find($userToColumnMap[$oldAppt['pc_aid']]);
                } else {
                    $column = $columnRepo->find(4);
                }
                $newAppt->setColumn($column);
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="Category">
                if (array_key_exists($oldAppt['pc_catid'], $categoryMap)) {
                    $category = $categoryRepo->find($categoryMap[$oldAppt['pc_catid']]);
                } else {
                    $category = $categoryRepo->find(14);
                }
                $newAppt->setCategory($category);
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="Status">
                $apptStatus = $apptStatusRepo->findOneBy(array('legacy_id' => $oldAppt['pc_apptstatus']));
                if (!$apptStatus) {
                    $apptStatus = $apptStatusRepo->findOneBy(array('legacy_id' => '-'));
                }
                $newAppt->setStatus($apptStatus);
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="DateTime">
                $newAppt->setStart(new \DateTime($oldAppt['pc_eventDate'] . ' ' . $oldAppt['pc_startTime']));
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="Duration">
                try{
                    $startTime = new \DateTime($oldAppt['pc_startTime']);
                    $endTime = new \DateTime($oldAppt['pc_endTime']);
                    $difference = $startTime->diff($endTime);
                    $minutes = $difference->h * 60;
                    $minutes += $difference->i;
                } catch (\Exception $ex) {
                    $minutes = 15;
                }

                $newAppt->setDuration($minutes);
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="Notes">
                $newAppt->setNotes($oldAppt['pc_hometext']);
                // </editor-fold>

                $patient = $patientRepo->find($oldAppt['pc_pid']);
                if ($patient) {
                    $newAppt->setPatient($patient);
                }

                $em->persist($newAppt);
                
                $metadata = $em->getClassMetaData(get_class($newAppt));
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            }

            $em->flush();
//            return new Response('Success');
            return $this->redirectToRoute('apptImport');
        } else {
            return new Response('Success');
        }
//        print_r($users);
    }

}
