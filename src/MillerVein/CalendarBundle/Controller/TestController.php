<?php

namespace MillerVein\CalendarBundle\Controller;

use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Exception;
use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;
use MillerVein\CalendarBundle\Session\LegacySessionStorage;
use MillerVein\CalendarBundle\Session\RootAttributeBag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Description of TestController
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class TestController extends Controller {
    /**
     * @Route("/fix", name="fix_stuff", options={"expose"=true})
     */
    public function fixAction(){
        $em = $this->getDoctrine()->getManager();
        $q = $em->createQuery(
                'SELECT  a '
                . ' FROM MillerVeinCalendarBundle:Appointment\PatientAppointment a '
                . ' WHERE a.id > 74336'
                );
        $results = $q->getResult();
        foreach($results as $result){
            echo $result->getId()."<br>";
            $result->legacyInsert();
        }
        return new \Symfony\Component\HttpFoundation\Response();
    }
    
    /**
     * @Route("/test")
     */
    public function theAction(Request $request){
//        session_start();
        echo "<HR>";
        $sessionStorage = new LegacySessionStorage();
        $session = new Session($sessionStorage);

        // before: $_SESSION['attribute']
        $legacyBag = new RootAttributeBag('attribute');
        $legacyBag->setName('legacy');

        // after: $session->getBag('legacy')->get()
        $session->registerBag($legacyBag);
        
//        echo session_id();
//        $sessionHandler = new NativeSessionHandler();
//        $sessionHandler->open('/var/php/session', session_id());
//        echo $sessionHandler->read(session_id());
//        $session = $request->getSession();
//        $session = new Session();
//        $session = new Session(new PhpBridgeSessionStorage());
        $session->start();
        $session->migrate();
        echo $session->get('legacy');
        print_r($_SESSION);
//        $session->migrate();
//        $session->save();
        foreach($session->all() as $key=>$something){
            echo $key.'<br>';
        }
//        echo $session->get('calendar_request_date')->format('Y-m-d');
        return new Response();
    }

    /**
     * @Route("/importOldAppointments", name="apptImport")
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

        $maxAppt = $db->fetchColumn('SELECT MAX(id) FROM calendar.appointment');
        if(!$maxAppt){
            $maxAppt = 0;
        }
        $workingAppts = $db->fetchAll('SELECT * FROM openemr.openemr_postcalendar_events e '
                . ' JOIN openemr.openemr_postcalendar_categories c '
                . ' ON e.pc_catid = c.pc_catid '
                . ' WHERE pc_eid > ? '
//                . ' AND e.pc_eventDate < "2015-04-01" '
                . ' AND c.pc_cattype = 0 '
                . ' ORDER BY pc_eid ASC LIMIT 1000', array($maxAppt));

        if ($workingAppts) {

            foreach ($workingAppts as $oldAppt) {
                $newAppt = new PatientAppointment();

                $newAppt->setId($oldAppt['pc_eid']);
                
                // <editor-fold defaultstate="collapsed" desc="Column">
                if($oldAppt['pc_eventDate'] >='2015-04-01'){
                    $cols = $columnRepo->findBy(array('legacy_provider'=>$oldAppt['pc_aid']),array('id'=>'DESC'));
                }else{
                    $cols = $columnRepo->findBy(array('legacy_provider'=>$oldAppt['pc_aid']));
                }
                if ($cols) {
                    $column = $cols[0];
                }else{
                    $column = $columnRepo->find(4);
                }
                $newAppt->setColumn($column);
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="Category">
                $cats = $categoryRepo->findBy(array('legacy_id'=>$oldAppt['pc_catid']));
                if ($cats) {
                    $category = $cats[0];
                }else{
                    $category = $categoryRepo->find(20);
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
                $newAppt->setStart(new DateTime($oldAppt['pc_eventDate'] . ' ' . $oldAppt['pc_startTime']));
                // </editor-fold>
                // <editor-fold defaultstate="collapsed" desc="Duration">
                try{
                    $startTime = new DateTime($oldAppt['pc_startTime']);
                    $endTime = new DateTime($oldAppt['pc_endTime']);
                    $difference = $startTime->diff($endTime);
                    $minutes = $difference->h * 60;
                    $minutes += $difference->i;
                } catch (Exception $ex) {
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
                $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

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
