<?php

namespace MillerVein\EMRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarketingCampaign
 *
 * @ORM\Table(name="openemr.marketing_campaign", indexes={@ORM\Index(name="user", columns={"user"}), @ORM\Index(name="marketing_source", columns={"marketing_source"})})
 * @ORM\Entity
 */
class MarketingCampaign
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="cost", type="decimal", precision=11, scale=2, nullable=true)
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="date", nullable=false)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=false)
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \MillerVein\EMRBundle\Entity\MarketingSource
     *
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\MarketingSource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marketing_source", referencedColumnName="id")
     * })
     */
    private $marketingSource;

    /**
     * @var \MillerVein\EMRBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;



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
     * Set name
     *
     * @param string $name
     * @return MarketingCampaign
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cost
     *
     * @param string $cost
     * @return MarketingCampaign
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return string 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return MarketingCampaign
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return MarketingCampaign
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return MarketingCampaign
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set marketingSource
     *
     * @param \MillerVein\EMRBundle\Entity\MarketingSource $marketingSource
     * @return MarketingCampaign
     */
    public function setMarketingSource(\MillerVein\EMRBundle\Entity\MarketingSource $marketingSource = null)
    {
        $this->marketingSource = $marketingSource;

        return $this;
    }

    /**
     * Get marketingSource
     *
     * @return \MillerVein\EMRBundle\Entity\MarketingSource 
     */
    public function getMarketingSource()
    {
        return $this->marketingSource;
    }

    /**
     * Set user
     *
     * @param \MillerVein\EMRBundle\Entity\Users $user
     * @return MarketingCampaign
     */
    public function setUser(\MillerVein\EMRBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MillerVein\EMRBundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }
}
