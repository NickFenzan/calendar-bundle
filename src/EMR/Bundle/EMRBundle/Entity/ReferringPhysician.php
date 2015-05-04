<?php

namespace EMR\Bundle\EMRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReferringPhysician
 *
 * @ORM\Table(name="openemr.referring_physician", indexes={@ORM\Index(name="lastUpdatedBy", columns={"lastUpdatedBy"})})
 * @ORM\Entity
 */
class ReferringPhysician
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=255, nullable=false)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=255, nullable=false)
     */
    private $lname;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=10, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=2, nullable=true)
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="zip", type="integer", nullable=true)
     */
    private $zip;

    /**
     * @var boolean
     *
     * @ORM\Column(name="scleroBack", type="boolean", nullable=false)
     */
    private $scleroback;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdated", type="datetime", nullable=false)
     */
    private $lastupdated;

    /**
     * @var \EMR\Bundle\EMRBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="EMR\Bundle\EMRBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lastUpdatedBy", referencedColumnName="id")
     * })
     */
    private $lastupdatedby;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fname
     *
     * @param string $fname
     * @return ReferringPhysician
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return ReferringPhysician
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string 
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ReferringPhysician
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return ReferringPhysician
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return ReferringPhysician
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return ReferringPhysician
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param integer $zip
     * @return ReferringPhysician
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return integer 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set scleroback
     *
     * @param boolean $scleroback
     * @return ReferringPhysician
     */
    public function setScleroback($scleroback)
    {
        $this->scleroback = $scleroback;

        return $this;
    }

    /**
     * Get scleroback
     *
     * @return boolean 
     */
    public function getScleroback()
    {
        return $this->scleroback;
    }

    /**
     * Set lastupdated
     *
     * @param \DateTime $lastupdated
     * @return ReferringPhysician
     */
    public function setLastupdated($lastupdated)
    {
        $this->lastupdated = $lastupdated;

        return $this;
    }

    /**
     * Get lastupdated
     *
     * @return \DateTime 
     */
    public function getLastupdated()
    {
        return $this->lastupdated;
    }

    /**
     * Set lastupdatedby
     *
     * @param \EMR\Bundle\EMRBundle\Entity\Users $lastupdatedby
     * @return ReferringPhysician
     */
    public function setLastupdatedby(\EMR\Bundle\EMRBundle\Entity\Users $lastupdatedby = null)
    {
        $this->lastupdatedby = $lastupdatedby;

        return $this;
    }

    /**
     * Get lastupdatedby
     *
     * @return \EMR\Bundle\EMRBundle\Entity\Users 
     */
    public function getLastupdatedby()
    {
        return $this->lastupdatedby;
    }
}
