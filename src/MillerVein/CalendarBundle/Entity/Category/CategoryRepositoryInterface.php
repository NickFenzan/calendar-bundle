<?php

namespace MillerVein\CalendarBundle\Entity\Category;

use Doctrine\ORM\EntityRepository;
use MillerVein\CalendarBundle\Entity\ColumnTag;

/**
 * Description of CategoryRepository
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
interface CategoryRepositoryInterface {
    public function findByColumnTag(ColumnTag $columnTag);
}
