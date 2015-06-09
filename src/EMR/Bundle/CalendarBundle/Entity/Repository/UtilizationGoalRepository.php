<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use DateTime;
use EMR\Bundle\CalendarBundle\Entity\Spec\FilterDateRangeByDateRange;
use EMR\Bundle\CalendarBundle\Entity\Spec\FilterMetric;
use EMR\Bundle\CalendarBundle\Entity\UtilizationMetric;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Spec;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationGoalRepository extends EntitySpecificationRepository {

    public function findActiveGoalForMetricByDateRange(UtilizationMetric $metric, DateTime $startDate, DateTime $endDate) {
        $spec = Spec::andX(
            new FilterDateRangeByDateRange($startDate, $endDate), 
            new FilterMetric($metric), 
            Spec::orderBy('start_date', 'DESC'), 
            Spec::limit(1)
        );
        $results = $this->match($spec);
        if (count($results) > 0) {
            return array_shift($results);
        } else {
            return null;
        }
    }

}
