<?php

namespace MillerVein\CalendarBundle\Entity\Category;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Category
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
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
// </editor-fold>

}
