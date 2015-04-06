<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MillerVein\EMRBundle\Entity\Site;
use MillerVein\EMRBundle\Entity\Users;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Column
 *
 * @ORM\Entity(repositoryClass="ColumnRepository")
 * @ORM\Table("calendar.calendar_column")
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
     * Legacy Provider.
     * @var \MillerVein\EMRBundle\Entity\Users
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\Users")
     */
    protected $legacy_provider;
    
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
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\Site", inversedBy="columns")
     */
    protected $site;
    
    /**
     * Associated Provider.
     * @var MillerVein\EMRBundle\Entity\Users
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\Users", inversedBy="calendar_columns")
     */
    protected $provider;

    /**
     * Regular hours of this column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Hours")
     * @ORM\OrderBy({"start_date" = "DESC", "id" = "DESC"})
     */
    protected $hours; 

    /**
     * Collection of tags that apply to the column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="ColumnTag", inversedBy="columns")
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

    public function getLegacyProvider() {
        return $this->legacy_provider;
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
    
    public function getProvider() {
        return $this->provider;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setId($id) {
        $this->id = $id;
    }
    
    public function setLegacyProvider(Users $legacy_provider) {
        $this->legacy_provider = $legacy_provider;
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

    public function setSite(Site $site) {
        $this->site = $site;
    }
    
    public function setProvider(Users $provider) {
        $this->provider = $provider;
    }

// </editor-fold>

    /**
     * @param \DateTime $date
     * @return \MillerVein\CalendarBundle\Entity\Hours
     */
    public function findHours(\DateTime $date) {
        $date = new \DateTime($date->format('Y-m-d'));
        foreach ($this->hours as $hours) {
            if ($hours->doHoursApplyToDate($date)) {
                return $hours;
            }
        }
        return null;
    }

}
