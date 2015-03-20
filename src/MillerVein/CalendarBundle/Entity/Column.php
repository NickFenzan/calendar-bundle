<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Column
 *
 * @ORM\Entity
 * @ORM\Table("calendar.column")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Column {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * Column ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Column name
     * @var string
     * @Assert\NotBlank() 
     * @ORM\Column(type="string")
     */
    protected $name;

    /**

     * Site this column belongs to.
     * @var Site
     * @ORM\ManyToOne(targetEntity="\MillerVein\EMRBundle\Entity\Site", inversedBy="columns")
     */
    protected $site;

    /**
     * Regular hours of this column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Hours")
     * @ORM\OrderBy({"start_date" = "DESC"})
     */
    protected $hours; 

    /**
     * Collection of tags that apply to the column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="ColumnTag")
     */
    protected $tags;
// </editor-fold>

    public function __construct() {
        $this->hours = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getHours() {
        return $this->hours;
    }
    
    public function getTags() {
        return $this->tags;
    }

    public function getSite() {
        return $this->site;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setHours(ArrayCollection $hours) {
        $this->hours = $hours;
    }
    
    public function setTags(ArrayCollection $tags) {
        $this->tags = $tags;
    }

    public function setSite(\MillerVein\EMRBundle\Entity\Site $site) {
        $this->site = $site;
    }

// </editor-fold>


}
