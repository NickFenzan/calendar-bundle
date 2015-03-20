<?php

namespace MillerVein\CalendarBundle\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Category
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity(repositoryClass="CategoryRepository")
 * @ORM\Table(name="calendar.appointment_category")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"patient" = "PatientCategory", "provider" = "ProviderCategory"})
 */
class Category {
    /**
     * Category ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * Category Name
     * @var string 
     * @ORM\Column()
     */
    protected $name;
    
    /**
     * Color
     * @var string 
     * @ORM\Column()
     */
    protected $color;
    
    /**
     * Default duration
     * @var integer 
     * @ORM\Column(type="smallint")
     */
    protected $default_duration;
    
    /**
     * Required Column Tags
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="MillerVein\CalendarBundle\Entity\ColumnTag")
     */
    protected $required_column_tags;
    
    public function __construct() {
        $this->required_column_tags = new ArrayCollection();
    }
    
// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getColor() {
        return $this->color;
    }

    public function getDefaultDuration() {
        return $this->default_duration;
    }
    
    public function getRequiredColumnTags() {
        return $this->required_column_tags;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setDefaultDuration($default_duration) {
        $this->default_duration = $default_duration;
    }
    
    public function setRequiredColumnTags(ArrayCollection $required_column_tags) {
        $this->required_column_tags = $required_column_tags;
    }


// </editor-fold>

}
