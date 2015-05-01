<?php

namespace MillerVein\Bundle\EMRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarketingSource
 *
 * @ORM\Table(name="openemr.marketing_source", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="user", columns={"user"})})
 * @ORM\Entity
 */
class MarketingSource
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
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
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \MillerVein\Bundle\EMRBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="MillerVein\Bundle\EMRBundle\Entity\Users")
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
     * @return MarketingSource
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
     * Set created
     *
     * @param \DateTime $created
     * @return MarketingSource
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
     * Set user
     *
     * @param \MillerVein\Bundle\EMRBundle\Entity\Users $user
     * @return MarketingSource
     */
    public function setUser(\MillerVein\Bundle\EMRBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MillerVein\Bundle\EMRBundle\Entity\Users 
     */
    public function getUser()
    {
        return $this->user;
    }
}
