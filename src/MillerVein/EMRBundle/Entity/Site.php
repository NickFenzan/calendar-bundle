<?php

namespace MillerVein\EMRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="openemr.facility")
 * @ORM\Entity
 */
class Site
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=30, nullable=true)
     */
    private $fax;

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
     * @ORM\Column(name="state", type="string", length=50, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=11, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=10, nullable=true)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="federal_ein", type="string", length=15, nullable=true)
     */
    private $federalEin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="service_location", type="boolean", nullable=false)
     */
    private $serviceLocation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="billing_location", type="boolean", nullable=false)
     */
    private $billingLocation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="accepts_assignment", type="boolean", nullable=false)
     */
    private $acceptsAssignment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pos_code", type="boolean", nullable=true)
     */
    private $posCode;

    /**
     * @var string
     *
     * @ORM\Column(name="x12_sender_id", type="string", length=25, nullable=true)
     */
    private $x12SenderId;

    /**
     * @var string
     *
     * @ORM\Column(name="attn", type="string", length=65, nullable=true)
     */
    private $attn;

    /**
     * @var string
     *
     * @ORM\Column(name="domain_identifier", type="string", length=60, nullable=true)
     */
    private $domainIdentifier;

    /**
     * @var string
     *
     * @ORM\Column(name="facility_npi", type="string", length=15, nullable=true)
     */
    private $facilityNpi;

    /**
     * @var string
     *
     * @ORM\Column(name="tax_id_type", type="string", length=31, nullable=false)
     */
    private $taxIdType;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7, nullable=false)
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="primary_business_entity", type="integer", nullable=false)
     */
    private $primaryBusinessEntity;

    /**
     * @var boolean
     *
     * @ORM\Column(name="primary_physician", type="boolean", nullable=true)
     */
    private $primaryPhysician;



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
     * @return Facility
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
     * Set phone
     *
     * @param string $phone
     * @return Facility
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Facility
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * Set postalCode
     *
     * @param string $postalCode
     * @return Facility
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return Facility
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set federalEin
     *
     * @param string $federalEin
     * @return Facility
     */
    public function setFederalEin($federalEin)
    {
        $this->federalEin = $federalEin;

        return $this;
    }

    /**
     * Get federalEin
     *
     * @return string 
     */
    public function getFederalEin()
    {
        return $this->federalEin;
    }

    /**
     * Set serviceLocation
     *
     * @param boolean $serviceLocation
     * @return Facility
     */
    public function setServiceLocation($serviceLocation)
    {
        $this->serviceLocation = $serviceLocation;

        return $this;
    }

    /**
     * Get serviceLocation
     *
     * @return boolean 
     */
    public function getServiceLocation()
    {
        return $this->serviceLocation;
    }

    /**
     * Set billingLocation
     *
     * @param boolean $billingLocation
     * @return Facility
     */
    public function setBillingLocation($billingLocation)
    {
        $this->billingLocation = $billingLocation;

        return $this;
    }

    /**
     * Get billingLocation
     *
     * @return boolean 
     */
    public function getBillingLocation()
    {
        return $this->billingLocation;
    }

    /**
     * Set acceptsAssignment
     *
     * @param boolean $acceptsAssignment
     * @return Facility
     */
    public function setAcceptsAssignment($acceptsAssignment)
    {
        $this->acceptsAssignment = $acceptsAssignment;

        return $this;
    }

    /**
     * Get acceptsAssignment
     *
     * @return boolean 
     */
    public function getAcceptsAssignment()
    {
        return $this->acceptsAssignment;
    }

    /**
     * Set posCode
     *
     * @param boolean $posCode
     * @return Facility
     */
    public function setPosCode($posCode)
    {
        $this->posCode = $posCode;

        return $this;
    }

    /**
     * Get posCode
     *
     * @return boolean 
     */
    public function getPosCode()
    {
        return $this->posCode;
    }

    /**
     * Set x12SenderId
     *
     * @param string $x12SenderId
     * @return Facility
     */
    public function setX12SenderId($x12SenderId)
    {
        $this->x12SenderId = $x12SenderId;

        return $this;
    }

    /**
     * Get x12SenderId
     *
     * @return string 
     */
    public function getX12SenderId()
    {
        return $this->x12SenderId;
    }

    /**
     * Set attn
     *
     * @param string $attn
     * @return Facility
     */
    public function setAttn($attn)
    {
        $this->attn = $attn;

        return $this;
    }

    /**
     * Get attn
     *
     * @return string 
     */
    public function getAttn()
    {
        return $this->attn;
    }

    /**
     * Set domainIdentifier
     *
     * @param string $domainIdentifier
     * @return Facility
     */
    public function setDomainIdentifier($domainIdentifier)
    {
        $this->domainIdentifier = $domainIdentifier;

        return $this;
    }

    /**
     * Get domainIdentifier
     *
     * @return string 
     */
    public function getDomainIdentifier()
    {
        return $this->domainIdentifier;
    }

    /**
     * Set facilityNpi
     *
     * @param string $facilityNpi
     * @return Facility
     */
    public function setFacilityNpi($facilityNpi)
    {
        $this->facilityNpi = $facilityNpi;

        return $this;
    }

    /**
     * Get facilityNpi
     *
     * @return string 
     */
    public function getFacilityNpi()
    {
        return $this->facilityNpi;
    }

    /**
     * Set taxIdType
     *
     * @param string $taxIdType
     * @return Facility
     */
    public function setTaxIdType($taxIdType)
    {
        $this->taxIdType = $taxIdType;

        return $this;
    }

    /**
     * Get taxIdType
     *
     * @return string 
     */
    public function getTaxIdType()
    {
        return $this->taxIdType;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Facility
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set primaryBusinessEntity
     *
     * @param integer $primaryBusinessEntity
     * @return Facility
     */
    public function setPrimaryBusinessEntity($primaryBusinessEntity)
    {
        $this->primaryBusinessEntity = $primaryBusinessEntity;

        return $this;
    }

    /**
     * Get primaryBusinessEntity
     *
     * @return integer 
     */
    public function getPrimaryBusinessEntity()
    {
        return $this->primaryBusinessEntity;
    }

    /**
     * Set primaryPhysician
     *
     * @param boolean $primaryPhysician
     * @return Facility
     */
    public function setPrimaryPhysician($primaryPhysician)
    {
        $this->primaryPhysician = $primaryPhysician;

        return $this;
    }

    /**
     * Get primaryPhysician
     *
     * @return boolean 
     */
    public function getPrimaryPhysician()
    {
        return $this->primaryPhysician;
    }
}
