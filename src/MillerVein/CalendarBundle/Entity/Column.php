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
     * @ORM\ManyToOne(targetEntity="Site")
     */
    protected $site;

    /**
     * Regular hours of this column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Hours", inversedBy="columns")
     * @ORM\OrderBy({"start_date" = "DESC"})
     */
    protected $hours; // </editor-fold>

    public function __construct() {
        $this->hours = new ArrayCollection();
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

    public function setSite(Site $site) {
        $this->site = $site;
    }

// </editor-fold>


}
