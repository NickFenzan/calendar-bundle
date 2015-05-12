<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EMR\Bundle\CalendarBundle\Request\Admin\HoursAdminRequest;
use MillerVein\Component\DateTime\DateTimeRange;

/**
 * Description of HoursRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class HoursRepository extends EntityRepository {

    public function findActiveHours() {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $query = $qb->select('h')
                ->from('EMRCalendarBundle:Hours', 'h')
                ->where($qb->expr()->gte('h.end_date', ':date'))
                ->orWhere($qb->expr()->isNull('h.end_date'))
                ->setParameter('date', '2015-05-01')
                ->getQuery();
        return $query->getResult();
    }

    public function findByRequest(HoursAdminRequest $request) {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('h')
                ->from('EMRCalendarBundle:Hours', 'h');

        $startDate = $request->getStartDate();
        $endDate = $request->getEndDate();
        $openTime = $request->getOpenTime();
        $lunchStart = $request->getLunchStart();
        $lunchEnd = $request->getLunchEnd();
        $closeTime = $request->getCloseTime();

        $this->dateRangeWhere($qb, 'h.start_date', $startDate, 'date');
        $this->dateRangeWhere($qb, 'h.end_date', $endDate, 'date');
        $this->dateRangeWhere($qb, 'h.open_time', $openTime, 'time');
        $this->dateRangeWhere($qb, 'h.lunch_start', $lunchStart, 'time');
        $this->dateRangeWhere($qb, 'h.lunch_end', $lunchEnd, 'time');
        $this->dateRangeWhere($qb, 'h.close_time', $closeTime, 'time');

        if (!$request->getColumns()->isEmpty()) {
            $columns = [];
            foreach ($request->getColumns() as $column) {
                $columns[] = $column->getId();
            }
            $qb->join('h.columns', 'c');
            $qb->andWhere($qb->expr()->in('c.id', implode(',', $columns)));
        }

        $this->hoursDefaultSortOrder($qb);
        $query = $qb->getQuery();
        return $query->getResult();
    }

    private function dateRangeWhere(QueryBuilder $qb, $fieldName, DateTimeRange $value = null, $type = 'datetime') {
        if ($value === null) {
            $qb->andWhere($qb->expr()->isNull($fieldName));
            return;
        }
        $escapedFieldName = str_replace('.', '_', $fieldName);
        $between = $qb->expr()->between($fieldName, ":{$escapedFieldName}_start", ":{$escapedFieldName}_end");
        $criteria = ($value->getNullValid()) ? $qb->expr()->orX($between, $qb->expr()->isNull($fieldName)) : $between;
        $qb->andWhere($criteria);
        $qb->setParameter(":{$escapedFieldName}_start", $this->extractDateTimePortion($value->getStart(), $type));
        $qb->setParameter(":{$escapedFieldName}_end", $this->extractDateTimePortion($value->getEnd(), $type));
    }

    private function extractDateTimePortion(\DateTime $value, $type) {
        switch ($type) {
            case "date":
                return $value->format('Y-m-d');
            case "time":
                return $value->format('H:i:s');
        }
        return $value->format('Y-m-d H:i:s');
    }

    private function hoursDefaultSortOrder(QueryBuilder $qb){
        $qb->addSelect('(CASE WHEN h.open_time is null then 1 else 0 END) AS HIDDEN nullOpen');
        $qb->addSelect('(CASE WHEN h.end_date is null then 1 else 0 END) AS HIDDEN nullEndDate');
        $qb->addOrderBy('nullOpen', 'DESC');
        $qb->addOrderBy('nullEndDate', 'ASC');
        $qb->addOrderBy('h.id');
    }
    
}
