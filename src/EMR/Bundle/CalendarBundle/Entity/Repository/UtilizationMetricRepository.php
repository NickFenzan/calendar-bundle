<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use EMR\Bundle\CalendarBundle\Entity\Spec\FilterDateRangeByDateRange;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Spec;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationMetricRepository extends EntitySpecificationRepository {

    public function findMetricsWithGoalsInDateRange(\DateTime $startDate, \DateTime $endDate) {
        $spec = Spec::andX(
            Spec::join('goals', 'g'), 
            new FilterDateRangeByDateRange($startDate, $endDate, 'g')
        );
        return $this->match($spec);
    }

}
