<?php

namespace EMR\Bundle\PatientTrackerBundle\EventListener;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use EMR\Bundle\CalendarBundle\Entity\Appointment\PatientAppointment;
use EMR\Bundle\PatientTrackerBundle\Entity\PatientTrackerStep;
use EMR\Bundle\PatientTrackerBundle\Entity\PatientTrackerVisit;

/**
 * Description of AppointmentEventListener
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class AppointmentEventListener {

    public function onFlush(OnFlushEventArgs $args) {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            if ($entity instanceof PatientAppointment) {
                if($entity->createEncounterCondition()){
                $this->createAppointmentReminderStep($em, $entity);
                }
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof PatientAppointment) {
                if($entity->createEncounterCondition()){
                $this->createAppointmentReminderStep($em, $entity);
                }
            }
        }
    }

    protected function createAppointmentReminderStep(EntityManager $entityManager, PatientAppointment $entity) {
        $roomRepo = $entityManager->getRepository('EMRPatientTrackerBundle:Room');
        $site = $entity->getColumn()->getSite();
        $lobby = $roomRepo->findLobbyBySite($site);

        $stepMetadata = $entityManager->getClassMetadata('EMR\Bundle\PatientTrackerBundle\Entity\PatientTrackerStep');
        $visitMetadata = $entityManager->getClassMetadata('EMR\Bundle\PatientTrackerBundle\Entity\PatientTrackerVisit');

        if ($lobby) {
            $uow = $entityManager->getUnitOfWork();
            
            $visit = new PatientTrackerVisit();
            $visit->setAppointment($entity);
            $entityManager->persist($visit);
            $uow->computeChangeSet($visitMetadata, $visit);

            $step = new PatientTrackerStep();
            $step->setDatetime(new DateTime());
            $step->setRoom($lobby);
            $entityManager->persist($step);
            $uow->computeChangeSet($stepMetadata, $step);

            $step->setVisit($visit);
            $uow->recomputeSingleEntityChangeSet($stepMetadata, $step);
        }
    }

}
