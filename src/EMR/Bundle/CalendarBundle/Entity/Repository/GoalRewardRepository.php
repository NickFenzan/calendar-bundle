<?php

namespace EMR\Bundle\CalendarBundle\Entity\Repository;

use DateTime;
use EMR\Bundle\CalendarBundle\Entity\Spec\FilterDateRangeByDateRange;
use Happyr\DoctrineSpecification\EntitySpecificationRepository;
use Happyr\DoctrineSpecification\Spec;

/**
 * @author Nick Fenzan <nickf@millervein.com>
 */
class GoalRewardRepository extends EntitySpecificationRepository{
    public function findRewardByDateRange(DateTime $start_date, DateTime $end_date){
        $spec = Spec::andX( 
                new FilterDateRangeByDateRange($start_date, $end_date),
                Spec::orderBy('goal_threshold')
                );
        return $this->match($spec);
    }
}
