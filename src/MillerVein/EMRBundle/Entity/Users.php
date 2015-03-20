<?php

namespace MillerVein\EMRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="openemr.users")
 * @ORM\Entity
 */
class Users
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
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", nullable=true)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="authorized", type="boolean", nullable=true)
     */
    private $authorized;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @var boolean
     *
     * @ORM\Column(name="source", type="boolean", nullable=true)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=255, nullable=true)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="mname", type="string", length=255, nullable=true)
     */
    private $mname;

    /**
     * @var string
     *
     * @ORM\Column(name="lname", type="string", length=255, nullable=true)
     */
    private $lname;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", nullable=true)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(name="federaltaxid", type="string", length=255, nullable=true)
     */
    private $federaltaxid;

    /**
     * @var string
     *
     * @ORM\Column(name="federaldrugid", type="string", length=255, nullable=true)
     */
    private $federaldrugid;

    /**
     * @var string
     *
     * @ORM\Column(name="upin", type="string", length=255, nullable=true)
     */
    private $upin;

    /**
     * @var string
     *
     * @ORM\Column(name="facility", type="string", length=255, nullable=true)
     */
    private $facility;

    /**
     * @var integer
     *
     * @ORM\Column(name="facility_id", type="integer", nullable=false)
     */
    private $facilityId;

    /**
     * @var integer
     *
     * @ORM\Column(name="see_auth", type="integer", nullable=false)
     */
    private $seeAuth;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="npi", type="string", length=15, nullable=true)
     */
    private $npi;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=30, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="specialty", type="string", length=255, nullable=true)
     */
    private $specialty;

    /**
     * @var string
     *
     * @ORM\Column(name="billname", type="string", length=255, nullable=true)
     */
    private $billname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="assistant", type="string", length=255, nullable=true)
     */
    private $assistant;

    /**
     * @var string
     *
     * @ORM\Column(name="organization", type="string", length=255, nullable=true)
     */
    private $organization;

    /**
     * @var string
     *
     * @ORM\Column(name="valedictory", type="string", length=255, nullable=true)
     */
    private $valedictory;

    /**
     * @var string
     *
     * @ORM\Column(name="spouse", type="string", length=60, nullable=true)
     */
    private $spouse;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=60, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="streetb", type="string", length=60, nullable=true)
     */
    private $streetb;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=30, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=20, nullable=true)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="street2", type="string", length=60, nullable=true)
     */
    private $street2;

    /**
     * @var string
     *
     * @ORM\Column(name="streetb2", type="string", length=60, nullable=true)
     */
    private $streetb2;

    /**
     * @var string
     *
     * @ORM\Column(name="city2", type="string", length=30, nullable=true)
     */
    private $city2;

    /**
     * @var string
     *
     * @ORM\Column(name="state2", type="string", length=30, nullable=true)
     */
    private $state2;

    /**
     * @var string
     *
     * @ORM\Column(name="zip2", type="string", length=20, nullable=true)
     */
    private $zip2;

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
     * @ORM\Column(name="phonew1", type="string", length=30, nullable=true)
     */
    private $phonew1;

    /**
     * @var string
     *
     * @ORM\Column(name="phonew2", type="string", length=30, nullable=true)
     */
    private $phonew2;

    /**
     * @var string
     *
     * @ORM\Column(name="phonecell", type="string", length=30, nullable=true)
     */
    private $phonecell;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cal_ui", type="boolean", nullable=false)
     */
    private $calUi;

    /**
     * @var string
     *
     * @ORM\Column(name="taxonomy", type="string", length=30, nullable=false)
     */
    private $taxonomy;

    /**
     * @var string
     *
     * @ORM\Column(name="ssi_relayhealth", type="string", length=64, nullable=true)
     */
    private $ssiRelayhealth;

    /**
     * @var boolean
     *
     * @ORM\Column(name="calendar", type="boolean", nullable=false)
     */
    private $calendar;

    /**
     * @var string
     *
     * @ORM\Column(name="abook_type", type="string", length=31, nullable=false)
     */
    private $abookType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pwd_expiration_date", type="date", nullable=true)
     */
    private $pwdExpirationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd_history1", type="text", nullable=true)
     */
    private $pwdHistory1;

    /**
     * @var string
     *
     * @ORM\Column(name="pwd_history2", type="text", nullable=true)
     */
    private $pwdHistory2;

    /**
     * @var string
     *
     * @ORM\Column(name="default_warehouse", type="string", length=31, nullable=false)
     */
    private $defaultWarehouse;

    /**
     * @var string
     *
     * @ORM\Column(name="irnpool", type="string", length=31, nullable=false)
     */
    private $irnpool;

    /**
     * @var string
     *
     * @ORM\Column(name="state_license_number", type="string", length=25, nullable=true)
     */
    private $stateLicenseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="newcrop_user_role", type="string", length=30, nullable=true)
     */
    private $newcropUserRole;

    /**
     * @var boolean
     *
     * @ORM\Column(name="physician", type="boolean", nullable=false)
     */
    private $physician;

    /**
     * @var boolean
     *
     * @ORM\Column(name="clinical", type="boolean", nullable=false)
     */
    private $clinical;

    /**
     * @var boolean
     *
     * @ORM\Column(name="admin", type="boolean", nullable=false)
     */
    private $admin;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=10, nullable=true)
     */
    private $role;

    /**
     * @var integer
     *
     * @ORM\Column(name="calendar_order", type="smallint", nullable=true)
     */
    private $calendarOrder;

    /**
     * @var integer
     *
     * @ORM\Column(name="linkToProvider", type="integer", nullable=true)
     */
    private $linktoprovider;



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
     * Set username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set authorized
     *
     * @param boolean $authorized
     * @return Users
     */
    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }

    /**
     * Get authorized
     *
     * @return boolean 
     */
    public function getAuthorized()
    {
        return $this->authorized;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return Users
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set source
     *
     * @param boolean $source
     * @return Users
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return boolean 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set fname
     *
     * @param string $fname
     * @return Users
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
     * Set mname
     *
     * @param string $mname
     * @return Users
     */
    public function setMname($mname)
    {
        $this->mname = $mname;

        return $this;
    }

    /**
     * Get mname
     *
     * @return string 
     */
    public function getMname()
    {
        return $this->mname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return Users
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
     * Set sex
     *
     * @param string $sex
     * @return Users
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string 
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set federaltaxid
     *
     * @param string $federaltaxid
     * @return Users
     */
    public function setFederaltaxid($federaltaxid)
    {
        $this->federaltaxid = $federaltaxid;

        return $this;
    }

    /**
     * Get federaltaxid
     *
     * @return string 
     */
    public function getFederaltaxid()
    {
        return $this->federaltaxid;
    }

    /**
     * Set federaldrugid
     *
     * @param string $federaldrugid
     * @return Users
     */
    public function setFederaldrugid($federaldrugid)
    {
        $this->federaldrugid = $federaldrugid;

        return $this;
    }

    /**
     * Get federaldrugid
     *
     * @return string 
     */
    public function getFederaldrugid()
    {
        return $this->federaldrugid;
    }

    /**
     * Set upin
     *
     * @param string $upin
     * @return Users
     */
    public function setUpin($upin)
    {
        $this->upin = $upin;

        return $this;
    }

    /**
     * Get upin
     *
     * @return string 
     */
    public function getUpin()
    {
        return $this->upin;
    }

    /**
     * Set facility
     *
     * @param string $facility
     * @return Users
     */
    public function setFacility($facility)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * Get facility
     *
     * @return string 
     */
    public function getFacility()
    {
        return $this->facility;
    }

    /**
     * Set facilityId
     *
     * @param integer $facilityId
     * @return Users
     */
    public function setFacilityId($facilityId)
    {
        $this->facilityId = $facilityId;

        return $this;
    }

    /**
     * Get facilityId
     *
     * @return integer 
     */
    public function getFacilityId()
    {
        return $this->facilityId;
    }

    /**
     * Set seeAuth
     *
     * @param integer $seeAuth
     * @return Users
     */
    public function setSeeAuth($seeAuth)
    {
        $this->seeAuth = $seeAuth;

        return $this;
    }

    /**
     * Get seeAuth
     *
     * @return integer 
     */
    public function getSeeAuth()
    {
        return $this->seeAuth;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Users
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set npi
     *
     * @param string $npi
     * @return Users
     */
    public function setNpi($npi)
    {
        $this->npi = $npi;

        return $this;
    }

    /**
     * Get npi
     *
     * @return string 
     */
    public function getNpi()
    {
        return $this->npi;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Users
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
     * Set specialty
     *
     * @param string $specialty
     * @return Users
     */
    public function setSpecialty($specialty)
    {
        $this->specialty = $specialty;

        return $this;
    }

    /**
     * Get specialty
     *
     * @return string 
     */
    public function getSpecialty()
    {
        return $this->specialty;
    }

    /**
     * Set billname
     *
     * @param string $billname
     * @return Users
     */
    public function setBillname($billname)
    {
        $this->billname = $billname;

        return $this;
    }

    /**
     * Get billname
     *
     * @return string 
     */
    public function getBillname()
    {
        return $this->billname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Users
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set assistant
     *
     * @param string $assistant
     * @return Users
     */
    public function setAssistant($assistant)
    {
        $this->assistant = $assistant;

        return $this;
    }

    /**
     * Get assistant
     *
     * @return string 
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     * Set organization
     *
     * @param string $organization
     * @return Users
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return string 
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set valedictory
     *
     * @param string $valedictory
     * @return Users
     */
    public function setValedictory($valedictory)
    {
        $this->valedictory = $valedictory;

        return $this;
    }

    /**
     * Get valedictory
     *
     * @return string 
     */
    public function getValedictory()
    {
        return $this->valedictory;
    }

    /**
     * Set spouse
     *
     * @param string $spouse
     * @return Users
     */
    public function setSpouse($spouse)
    {
        $this->spouse = $spouse;

        return $this;
    }

    /**
     * Get spouse
     *
     * @return string 
     */
    public function getSpouse()
    {
        return $this->spouse;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Users
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
     * Set streetb
     *
     * @param string $streetb
     * @return Users
     */
    public function setStreetb($streetb)
    {
        $this->streetb = $streetb;

        return $this;
    }

    /**
     * Get streetb
     *
     * @return string 
     */
    public function getStreetb()
    {
        return $this->streetb;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Users
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
     * @return Users
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
     * @param string $zip
     * @return Users
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string 
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set street2
     *
     * @param string $street2
     * @return Users
     */
    public function setStreet2($street2)
    {
        $this->street2 = $street2;

        return $this;
    }

    /**
     * Get street2
     *
     * @return string 
     */
    public function getStreet2()
    {
        return $this->street2;
    }

    /**
     * Set streetb2
     *
     * @param string $streetb2
     * @return Users
     */
    public function setStreetb2($streetb2)
    {
        $this->streetb2 = $streetb2;

        return $this;
    }

    /**
     * Get streetb2
     *
     * @return string 
     */
    public function getStreetb2()
    {
        return $this->streetb2;
    }

    /**
     * Set city2
     *
     * @param string $city2
     * @return Users
     */
    public function setCity2($city2)
    {
        $this->city2 = $city2;

        return $this;
    }

    /**
     * Get city2
     *
     * @return string 
     */
    public function getCity2()
    {
        return $this->city2;
    }

    /**
     * Set state2
     *
     * @param string $state2
     * @return Users
     */
    public function setState2($state2)
    {
        $this->state2 = $state2;

        return $this;
    }

    /**
     * Get state2
     *
     * @return string 
     */
    public function getState2()
    {
        return $this->state2;
    }

    /**
     * Set zip2
     *
     * @param string $zip2
     * @return Users
     */
    public function setZip2($zip2)
    {
        $this->zip2 = $zip2;

        return $this;
    }

    /**
     * Get zip2
     *
     * @return string 
     */
    public function getZip2()
    {
        return $this->zip2;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Users
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
     * @return Users
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
     * Set phonew1
     *
     * @param string $phonew1
     * @return Users
     */
    public function setPhonew1($phonew1)
    {
        $this->phonew1 = $phonew1;

        return $this;
    }

    /**
     * Get phonew1
     *
     * @return string 
     */
    public function getPhonew1()
    {
        return $this->phonew1;
    }

    /**
     * Set phonew2
     *
     * @param string $phonew2
     * @return Users
     */
    public function setPhonew2($phonew2)
    {
        $this->phonew2 = $phonew2;

        return $this;
    }

    /**
     * Get phonew2
     *
     * @return string 
     */
    public function getPhonew2()
    {
        return $this->phonew2;
    }

    /**
     * Set phonecell
     *
     * @param string $phonecell
     * @return Users
     */
    public function setPhonecell($phonecell)
    {
        $this->phonecell = $phonecell;

        return $this;
    }

    /**
     * Get phonecell
     *
     * @return string 
     */
    public function getPhonecell()
    {
        return $this->phonecell;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Users
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set calUi
     *
     * @param boolean $calUi
     * @return Users
     */
    public function setCalUi($calUi)
    {
        $this->calUi = $calUi;

        return $this;
    }

    /**
     * Get calUi
     *
     * @return boolean 
     */
    public function getCalUi()
    {
        return $this->calUi;
    }

    /**
     * Set taxonomy
     *
     * @param string $taxonomy
     * @return Users
     */
    public function setTaxonomy($taxonomy)
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    /**
     * Get taxonomy
     *
     * @return string 
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }

    /**
     * Set ssiRelayhealth
     *
     * @param string $ssiRelayhealth
     * @return Users
     */
    public function setSsiRelayhealth($ssiRelayhealth)
    {
        $this->ssiRelayhealth = $ssiRelayhealth;

        return $this;
    }

    /**
     * Get ssiRelayhealth
     *
     * @return string 
     */
    public function getSsiRelayhealth()
    {
        return $this->ssiRelayhealth;
    }

    /**
     * Set calendar
     *
     * @param boolean $calendar
     * @return Users
     */
    public function setCalendar($calendar)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar
     *
     * @return boolean 
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * Set abookType
     *
     * @param string $abookType
     * @return Users
     */
    public function setAbookType($abookType)
    {
        $this->abookType = $abookType;

        return $this;
    }

    /**
     * Get abookType
     *
     * @return string 
     */
    public function getAbookType()
    {
        return $this->abookType;
    }

    /**
     * Set pwdExpirationDate
     *
     * @param \DateTime $pwdExpirationDate
     * @return Users
     */
    public function setPwdExpirationDate($pwdExpirationDate)
    {
        $this->pwdExpirationDate = $pwdExpirationDate;

        return $this;
    }

    /**
     * Get pwdExpirationDate
     *
     * @return \DateTime 
     */
    public function getPwdExpirationDate()
    {
        return $this->pwdExpirationDate;
    }

    /**
     * Set pwdHistory1
     *
     * @param string $pwdHistory1
     * @return Users
     */
    public function setPwdHistory1($pwdHistory1)
    {
        $this->pwdHistory1 = $pwdHistory1;

        return $this;
    }

    /**
     * Get pwdHistory1
     *
     * @return string 
     */
    public function getPwdHistory1()
    {
        return $this->pwdHistory1;
    }

    /**
     * Set pwdHistory2
     *
     * @param string $pwdHistory2
     * @return Users
     */
    public function setPwdHistory2($pwdHistory2)
    {
        $this->pwdHistory2 = $pwdHistory2;

        return $this;
    }

    /**
     * Get pwdHistory2
     *
     * @return string 
     */
    public function getPwdHistory2()
    {
        return $this->pwdHistory2;
    }

    /**
     * Set defaultWarehouse
     *
     * @param string $defaultWarehouse
     * @return Users
     */
    public function setDefaultWarehouse($defaultWarehouse)
    {
        $this->defaultWarehouse = $defaultWarehouse;

        return $this;
    }

    /**
     * Get defaultWarehouse
     *
     * @return string 
     */
    public function getDefaultWarehouse()
    {
        return $this->defaultWarehouse;
    }

    /**
     * Set irnpool
     *
     * @param string $irnpool
     * @return Users
     */
    public function setIrnpool($irnpool)
    {
        $this->irnpool = $irnpool;

        return $this;
    }

    /**
     * Get irnpool
     *
     * @return string 
     */
    public function getIrnpool()
    {
        return $this->irnpool;
    }

    /**
     * Set stateLicenseNumber
     *
     * @param string $stateLicenseNumber
     * @return Users
     */
    public function setStateLicenseNumber($stateLicenseNumber)
    {
        $this->stateLicenseNumber = $stateLicenseNumber;

        return $this;
    }

    /**
     * Get stateLicenseNumber
     *
     * @return string 
     */
    public function getStateLicenseNumber()
    {
        return $this->stateLicenseNumber;
    }

    /**
     * Set newcropUserRole
     *
     * @param string $newcropUserRole
     * @return Users
     */
    public function setNewcropUserRole($newcropUserRole)
    {
        $this->newcropUserRole = $newcropUserRole;

        return $this;
    }

    /**
     * Get newcropUserRole
     *
     * @return string 
     */
    public function getNewcropUserRole()
    {
        return $this->newcropUserRole;
    }

    /**
     * Set physician
     *
     * @param boolean $physician
     * @return Users
     */
    public function setPhysician($physician)
    {
        $this->physician = $physician;

        return $this;
    }

    /**
     * Get physician
     *
     * @return boolean 
     */
    public function getPhysician()
    {
        return $this->physician;
    }

    /**
     * Set clinical
     *
     * @param boolean $clinical
     * @return Users
     */
    public function setClinical($clinical)
    {
        $this->clinical = $clinical;

        return $this;
    }

    /**
     * Get clinical
     *
     * @return boolean 
     */
    public function getClinical()
    {
        return $this->clinical;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return Users
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Users
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set calendarOrder
     *
     * @param integer $calendarOrder
     * @return Users
     */
    public function setCalendarOrder($calendarOrder)
    {
        $this->calendarOrder = $calendarOrder;

        return $this;
    }

    /**
     * Get calendarOrder
     *
     * @return integer 
     */
    public function getCalendarOrder()
    {
        return $this->calendarOrder;
    }

    /**
     * Set linktoprovider
     *
     * @param integer $linktoprovider
     * @return Users
     */
    public function setLinktoprovider($linktoprovider)
    {
        $this->linktoprovider = $linktoprovider;

        return $this;
    }

    /**
     * Get linktoprovider
     *
     * @return integer 
     */
    public function getLinktoprovider()
    {
        return $this->linktoprovider;
    }
}
