<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Column
 *
 * @ORM\Entity
 * @ORM\Table("calendar_column")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Column {
    /**
     * Column ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * Column name
     * @var string
     * @Assert\NotBlank() 
     * @ORM\Column(type="string")
     */
    private $name;

    /** 
     * Site this column belongs to.
     * @var Site
     * @ORM\ManyToOne(targetEntity="Site")
     */
    private $site;

    /**
     * Regular hours of this column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Hours", inversedBy="columns")
     */
    private $hours; 

    public function __construct() {
        $this->hours = new ArrayCollection();
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getHours() {
        return $this->hours;
    }
    
    public function getSite() {
        return $this->site;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setHours(ArrayCollection $hours) {
        $this->hours = $hours;
    }
    
    public function setSite(Site $site) {
        $this->site = $site;
    }

}
