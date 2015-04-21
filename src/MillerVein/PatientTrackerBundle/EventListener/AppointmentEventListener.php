<?php

namespace MillerVein\PatientTrackerBundle\EventListener;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\OnFlushEventArgs;
use MillerVein\CalendarBundle\Entity\Appointment\PatientAppointment;
use MillerVein\PatientTrackerBundle\Entity\PatientTrackerStep;
use MillerVein\PatientTrackerBundle\Entity\PatientTrackerVisit;

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
//                if($entity->createEncounterCondition()){
                    $this->createAppointmentReminderStep($em, $entity);
//                }
            }
        }

    }

    protected function createAppointmentReminderStep(EntityManager $entityManager, PatientAppointment $entity) {
        $roomRepo = $entityManager->getRepository('MillerVeinPatientTrackerBundle:Room');
        $lobby = $roomRepo->findLobbyBySite($entity->getColumn()->getSite());
        if($lobby){
            $uow = $entityManager->getUnitOfWork();
            
            $step = new PatientTrackerStep();
            $step->setDatetime(new DateTime());
            $step->setRoom($lobby);
            
            $visit = new PatientTrackerVisit();
            $visit->setAppointment($entity);
            $visit->addStep($step);
//            $uow->persist($step);
            $uow->persist($visit);

            $visitMetadata = $entityManager->getClassMetadata('MillerVein\PatientTrackerBundle\Entity\PatientTrackerVisit');
            $uow->computeChangeSet($visitMetadata, $visit);
            $uow->recomputeSingleEntityChangeSet($visitMetadata, $visit);
            $stepMetadata = $entityManager->getClassMetadata('MillerVein\PatientTrackerBundle\Entity\PatientTrackerStep');
            $uow->computeChangeSet($stepMetadata, $step);
            $uow->recomputeSingleEntityChangeSet($stepMetadata, $step);
        }
    }

}
