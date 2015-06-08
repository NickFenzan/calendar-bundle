<?php

namespace EMR\Bundle\CalendarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EMR\Bundle\CalendarBundle\Model\Collections\ColumnCollection;

/**
 * This is a named, saved group of columns with a goal attached.
 * It is intended to be used to pull reports on schedule utilization.
 *
 * @ORM\Entity(repositoryClass="EMR\Bundle\CalendarBundle\Entity\Repository\UtilizationMetricRepository")
 * @ORM\Table(name="calendar_utilization_metric")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class UtilizationMetric {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int 
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="ColumnTag")
     * @var ArrayCollection 
     */
    protected $tags;

    /**
     * @ORM\ManyToMany(targetEntity="Column")
     * @var ColumnCollection 
     */
    protected $columns;

    /**
     * @ORM\OneToMany(targetEntity="UtilizationGoal", mappedBy="metric")
     * @var ArrayCollection
     */
    protected $goals; 
// </editor-fold>

    public function __construct() {
        $this->tags = new ArrayCollection();
        $this->columns = new ColumnCollection();
        $this->goals = new ArrayCollection();
    }

// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function getGoals() {
        return $this->goals;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setTags(ArrayCollection $tags) {
        $this->tags = $tags;
        return $this;
    }

    public function setColumns(ColumnCollection $columns) {
        $this->columns = $columns;
        return $this;
    }

    public function setGoals(ArrayCollection $goals) {
        $this->goals = $goals;
        return $this;
    }

// </editor-fold>

}
