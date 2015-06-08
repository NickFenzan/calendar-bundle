<?php

namespace EMR\Bundle\CalendarBundle\Entity\Spec;

use EMR\Bundle\CalendarBundle\Entity\UtilizationMetric;
use Happyr\DoctrineSpecification\BaseSpecification;
use Happyr\DoctrineSpecification\Spec;

/**
 * Description of FilterMetric
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class FilterMetric extends BaseSpecification {

    protected $metric_id;

    public function __construct(UtilizationMetric $metric, $dqlAlias = null) {
        parent::__construct($dqlAlias);
        $this->metric_id = $metric->getId();
    }

    protected function getSpec() {
        return Spec::andX(
            Spec::join('metric', 'm'),
            Spec::eq('id', $this->metric_id,'m')
        );
    }

}
