<?php

namespace EMR\Bundle\CalendarBundle\Entity\Appointment;

use Doctrine\ORM\Mapping as ORM;
use EMR\Bundle\CalendarBundle\Entity\AppointmentStatus;
use EMR\Bundle\LegacyBundle\Entity\PatientData;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Patient
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class PatientAppointment extends Appointment {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @var EMRPatient
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="EMR\Bundle\LegacyBundle\Entity\PatientData")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="pid")
     * */
    protected $patient;

    /**
     * @var int 
     * @ORM\Column(type="integer")
     */
    protected $encounter_id;

    /**
     *
     * @var string
     * @ORM\Column(length=10)
     */
    protected $leg;

    /**
     * This gets set on appointments that created a new encounter.
     * This is so that later on doctrine listeners can know.
     */
    protected $creatingAnEncounterFlag = false;

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Getters">

    public function getType() {
        return "patient";
    }

    public function getPatient() {
        return $this->patient;
    }

    public function getLeg() {
        return $this->leg;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setPatient(PatientData $patient) {
        $this->patient = $patient;
    }

    public function setLeg($leg) {
        $this->leg = $leg;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Encounter Creation">
    public function createEncounterCondition() {
        return (
                (null === $this->encounter_id && $this->start->format('Y-m-d') === date('Y-m-d') && $this->status->isAutoCreateEncounter()) || $this->creatingAnEncounterFlag
                ) ? true : false;
    }

    protected function createEncounter() {
        $sql = "INSERT INTO form_encounter "
                . " SET "
                . " date = :date, "
                . " reason = '', "
                . " facility = :facility_name, "
                . " facility_id = :facility_id, "
                . " pid = :pid, "
                . " encounter = :encounter, "
                . " onset_date = :date, "
                . " pc_catid = :catid, "
                . " provider_id = :provider_id, "
                . " billing_facility = 3 "
        ;
        $formsSql = "INSERT INTO forms "
                . " SET "
                . " date = NOW(),"
                . " encounter = :encounter, "
                . " form_name = 'New Patient Encounter', "
                . " form_id = :formId, "
                . " pid = :pid, "
                . " user = 'admin', "
                . " groupname = 'Default', "
                . " authorized = 1, "
                . " deleted = 0, "
                . " formdir = 'newpatient' "
        ;
        try {
            $pdo = $this->sqlConnect();
            $pdo->beginTransaction();
            $pdo->exec('UPDATE sequences SET id = id+1');
            $sequenceResults = $pdo->query("SELECT id FROM sequences")->fetch();
            $encounterNumber = $sequenceResults[0];
            if (empty($encounterNumber)) {
                $pdo->rollBack();
            }
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':date', date('Y-m-d') . ' 00:00:00');
            $statement->bindValue(':facility_name', $this->column->getSite()->getName());
            $statement->bindValue(':facility_id', $this->column->getSite()->getId());
            $statement->bindValue(':pid', $this->patient->getId());
            $statement->bindValue(':encounter', $encounterNumber);
            $statement->bindValue(':catid', $this->category->getLegacyId());
            $statement->bindValue(':provider_id', $this->column->getProvider()->getId());
            $statement->execute();
            $formId = $pdo->lastInsertId();
            $formStatement = $pdo->prepare($formsSql);
            $formStatement->bindValue(':formId', $formId);
            $formStatement->bindValue(':encounter', $encounterNumber);
            $formStatement->bindValue(':pid', $this->patient->getId());
            $formStatement->execute();
            $commit = $pdo->commit();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            die();
        }
        if ($commit) {
            $this->encounter_id = $encounterNumber;
            $this->creatingAnEncounterFlag = true;
        }
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Legacy Database">
    public function legacyInsert() {
// <editor-fold defaultstate="collapsed" desc="Statement">
        $sql = "INSERT INTO openemr_postcalendar_events "
                . " SET "
                . " pc_eid = :id, "
                . " pc_encounter = :encounter, "
                . " pc_catid = :catid, "
                . " pc_multiple = 0, "
                . " pc_aid = :provider_id, "
                . " pc_pid = :pid, "
                . " pc_title = :cat_name, "
                . " pc_time = :now, "
                . " pc_createTime = :now, "
                . " pc_hometext = :notes, "
                . " pc_comments = 0, "
                . " pc_counter = 0, "
                . " pc_topic = 1, "
                . " pc_informant = :session_user, "
                . " pc_creator = :session_user, "
                . " pc_eventDate = :appt_date, "
                . " pc_endDate = '0000-00-00', "
                . " pc_duration = :duration, "
                . " pc_recurrtype = 0, "
                . " pc_recurrspec = :defaultRecur, "
                . " pc_recurrfreq = 0, "
                . " pc_startTime = :start_time, "
                . " pc_endTime = :end_time, "
                . " pc_alldayevent = 0, "
                . " pc_location = :defaultLocation, "
                . " pc_conttel = '', "
                . " pc_contname = '', "
                . " pc_contemail = '', "
                . " pc_website = '', "
                . " pc_eventstatus = 1, "
                . " pc_sharing = 1, "
                . " pc_language = '', "
                . " pc_apptstatus = :appt_status, "
                . " pc_prefcatid = 0, "
                . " pc_facility = :facility, "
                . " pc_sendalertsms = 'NO', "
                . " pc_sendalertemail = 'NO', "
                . " pc_billing_location = 3, "
                . " pc_reminder = NULL, "
                . " pc_whichLeg = :whichLeg, "
                . " pc_currentRoom = NULL "
        ; // </editor-fold>
        $pdo = $this->sqlConnect();
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $this->id);
            $statement->bindValue(':encounter', $this->encounter_id);
            $statement->bindValue(':catid', $this->category->getLegacyId());
            $statement->bindValue(':provider_id', $this->column->getLegacyProvider()->getId());
            $statement->bindValue(':pid', $this->patient->getId());
            $statement->bindValue(':cat_name', $this->category->getName());
            $statement->bindValue(':now', date('Y-m-d H:i:s'));
            $statement->bindValue(':notes', $this->notes);
            $statement->bindValue(':session_user', '1');
            $statement->bindValue(':appt_date', $this->start->format('Y-m-d'));
            $statement->bindValue(':duration', $this->duration);
            $statement->bindValue(':defaultRecur', self::DefaultRecur);
            $statement->bindValue(':start_time', $this->start->format('H:i:s'));
            $statement->bindValue(':end_time', $this->end->format('H:i:s'));
            $statement->bindValue(':defaultLocation', self::DefaultLocation);
            $statement->bindValue(':appt_status', $this->status->getLegacyId());
            $statement->bindValue(':facility', $this->column->getSite()->getId());
            $statement->bindValue(':whichLeg', $this->getLeg());
            $statement->execute();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            die();
        }
    }

    protected function legacyUpdate() {
// <editor-fold defaultstate="collapsed" desc="Statement">
        $sql = "UPDATE openemr_postcalendar_events "
                . " SET "
                . " pc_encounter = :encounter, "
                . " pc_catid = :catid, "
                . " pc_aid = :provider_id, "
                . " pc_pid = :pid, "
                . " pc_title = :cat_name, "
                . " pc_time = :now, "
                . " pc_hometext = :notes, "
                . " pc_informant = :session_user, "
                . " pc_eventDate = :appt_date, "
                . " pc_duration = :duration, "
                . " pc_startTime = :start_time, "
                . " pc_endTime = :end_time, "
                . " pc_apptstatus = :appt_status, "
                . " pc_facility = :facility, "
                . " pc_whichLeg = :whichLeg "
                . " WHERE "
                . " pc_eid = :id "
        ; // </editor-fold>
        $pdo = $this->sqlConnect();
        try {
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':id', $this->id);
            $statement->bindValue(':encounter', $this->encounter_id);
            $statement->bindValue(':catid', $this->category->getLegacyId());
            $statement->bindValue(':provider_id', $this->column->getLegacyProvider()->getId());
            $statement->bindValue(':pid', $this->patient->getId());
            $statement->bindValue(':cat_name', $this->category->getName());
            $statement->bindValue(':now', date('Y-m-d H:i:s'));
            $statement->bindValue(':notes', $this->notes);
            $statement->bindValue(':session_user', '1');
            $statement->bindValue(':appt_date', $this->start->format('Y-m-d'));
            $statement->bindValue(':duration', $this->duration);
            $statement->bindValue(':start_time', $this->start->format('H:i:s'));
            $statement->bindValue(':end_time', $this->end->format('H:i:s'));
            $statement->bindValue(':appt_status', $this->status->getLegacyId());
            $statement->bindValue(':facility', $this->column->getSite()->getId());
            $statement->bindValue(':whichLeg', $this->getLeg());
            $statement->execute();
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            die();
        }
    }

// </editor-fold>
    public function prePersist() {
        if ($this->createEncounterCondition()) {
            $this->createEncounter();
        }
        parent::prePersist();
    }

    public function preUpdate() {
        if ($this->createEncounterCondition()) {
            $this->createEncounter();
        }
        parent::preUpdate();
    }

}
