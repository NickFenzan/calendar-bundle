<?php

namespace EMR\Bundle\CalendarBundle\Entity\Appointment;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\QueryBuilder;
use EMR\Bundle\CalendarBundle\Request\AppointmentMoverRequest;
use MillerVein\Component\DateTime\DateTimeRange;
use ReflectionClass;
use ReflectionProperty;

/**
 * Description of PatientAppointmentRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class PatientAppointmentRepository extends AppointmentRepository {

    protected $joined_patient = false;
    protected $joined_category = false;
    protected $joined_column = false;

    public function match(AppointmentMoverRequest $request) {
        $this->resetJoins();
        $qb = $this->createQueryBuilder('a');
        $this->joinPatient($qb);
        $this->joinCategory($qb);
        $this->whereColumns($qb, $request->getFromColumns());
        $this->whereDateRange($qb, $request->getDateRange());
        if (!$request->getCategories()->isEmpty()) {
            $this->whereCategories($qb, $request->getCategories());
        }
        $query = $qb->getQuery();
        return $query->getResult();
    }

    protected function joinPatient(QueryBuilder $qb) {
        if (!$this->joined_patient) {
            $qb->addSelect('p');
            $qb->join('a.patient', 'p');
            $this->joined_patient = true;
        }
    }

    protected function joinColumn(QueryBuilder $qb) {
        if (!$this->joined_column) {
            $qb->addSelect('col');
            $qb->join('a.column', 'col');
            $this->joined_column = true;
        }
    }

    protected function joinCategory(QueryBuilder $qb) {
        if (!$this->joined_category) {
            $qb->addSelect('cat');
            $qb->join('a.category', 'cat');
            $this->joined_category = true;
        }
    }
    
    protected function resetJoins(){
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PROTECTED);
        foreach($props as $prop){
            $name = $prop->getName();
            if(stristr($name, 'joined_')){
                $this->$name = false;
            }
        }
    }

    protected function whereDateRange(QueryBuilder $qb, DateTimeRange $range) {
        $between = $qb->expr()->between('a.start', ':start', ':end');
        $criteria = ($range->getNullValid()) ? $qb->expr()->orX($between, $qb->expr()->isNull('a.start')) : $between;
        $qb->setParameter('start', $range->getStart());
        $qb->setParameter('end', $range->getEnd());
        $qb->andWhere($criteria);
    }

    protected function whereColumns(QueryBuilder $qb, Collection $collection) {
        $this->joinColumn($qb);
        $qb->andWhere($qb->expr()->in('col.id', ':col_ids'));
        $ids = $collection->map(function($entity) { return $entity->getId(); });
        $qb->setParameter('col_ids', $ids->toArray());
    }

    protected function whereCategories(QueryBuilder $qb, Collection $collection) {
        $this->joinCategory($qb);
        $qb->andWhere($qb->expr()->in('cat.id', ':cat_ids'));
        $qb->setParameter('cat_ids', $collection->getIds());
    }

}
