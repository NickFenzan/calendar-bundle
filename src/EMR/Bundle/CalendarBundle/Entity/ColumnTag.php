<?php

namespace EMR\Bundle\CalendarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Column
 *
 * @ORM\Entity(repositoryClass="EMR\Bundle\CalendarBundle\Entity\Repository\ColumnTagRepository")
 * @ORM\Table(name="calendar.column_tag")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class ColumnTag {
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
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="EMR\Bundle\CalendarBundle\Entity\Category\Category", mappedBy="required_column_tags")
     */
    protected $categories;
    /** 
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="EMR\Bundle\CalendarBundle\Entity\Column", mappedBy="tags")
     */
    protected $columns;
    
    public function __construct() {
        $this->categories = new ArrayCollection();
        $this->columns = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    function getCategories() {
        return $this->categories;
    }

    function getColumns() {
        return $this->columns;
    }

    function setCategories(ArrayCollection $categories) {
        $this->categories = $categories;
    }

    function setColumns(ArrayCollection $columns) {
        $this->columns = $columns;
    }


}
