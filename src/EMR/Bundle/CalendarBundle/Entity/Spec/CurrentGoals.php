<?php

namespace EMR\Bundle\CalendarBundle\Entity\Spec;

use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * Description of CurrentGoals
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class CurrentGoals extends BaseSpecification {

    /**
     * @var \DateTime
     */
    private $start_date;

    /**
     * @var \DateTime
     */
    private $end_date;

    public function __construct(\DateTime $startDate, \DateTime $endDate, $dqlAlias = null) {
        parent::__construct($dqlAlias);
        $this->start_date = $startDate;
        $this->end_date = $endDate;
    }

    protected function getSpec() {
        return Spec::andX(
                        Spec::lte('start_date', $this->start_date->format('Y-m-d')), 
                Spec::orX(
                        Spec::isNull('end_date'),
                        Spec::gte('end_date',$this->end_date->format('Y-m-d'))
                        )
        );
    }

}
