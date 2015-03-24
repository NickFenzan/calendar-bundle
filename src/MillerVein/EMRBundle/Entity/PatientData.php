<?php

namespace MillerVein\EMRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PatientData
 *
 * @ORM\Table(name="openemr.patient_data", uniqueConstraints={@ORM\UniqueConstraint(name="pid", columns={"pid"})}, indexes={@ORM\Index(name="phone_cell", columns={"phone_cell"}), @ORM\Index(name="phone_home", columns={"phone_home"}), @ORM\Index(name="phone_biz", columns={"phone_biz"}), @ORM\Index(name="marketink_campaign", columns={"marketing_campaign"}), @ORM\Index(name="referring_physician_auth", columns={"referring_physician"})})
 * @ORM\Entity(repositoryClass="PatientDataRepository")
 */
class PatientData
{
    /**
     * @var integer
     *
     * @ORM\Column(name="pid", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $pid;

    /**
     * @var string
     *
     * @ORM\Column(name="pubpid", type="string", length=255, nullable=true)
     */
    private $pubpid;

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=255, nullable=false)
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
     * @ORM\Column(name="lname", type="string", length=255, nullable=false)
     */
    private $lname;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DOB", type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string
     *
     * @ORM\Column(name="sex", type="string", length=255, nullable=false)
     */
    private $sex;

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
     * @ORM\Column(name="county", type="string", length=25, nullable=true)
     */
    private $county;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_home", type="string", length=255, nullable=true)
     */
    private $phoneHome;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_biz", type="string", length=255, nullable=true)
     */
    private $phoneBiz;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_cell", type="string", length=255, nullable=true)
     */
    private $phoneCell;

    /**
     * @var string
     *
     * @ORM\Column(name="best_number", type="string", length=255, nullable=true)
     */
    private $bestNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="emergency_name", type="string", length=255, nullable=true)
     */
    private $emergencyName;

    /**
     * @var string
     *
     * @ORM\Column(name="emergency_number", type="string", length=255, nullable=true)
     */
    private $emergencyNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hipaa_mail", type="boolean", nullable=true)
     */
    private $hipaaMail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hipaa_email", type="boolean", nullable=true)
     */
    private $hipaaEmail;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hipaa_cell_phone", type="boolean", nullable=true)
     */
    private $hipaaCellPhone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hipaa_home_phone", type="boolean", nullable=true)
     */
    private $hipaaHomePhone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hipaa_work_phone", type="boolean", nullable=true)
     */
    private $hipaaWorkPhone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hipaa_voicemail", type="boolean", nullable=true)
     */
    private $hipaaVoicemail;

    /**
     * @var string
     *
     * @ORM\Column(name="occupation", type="text", nullable=true)
     */
    private $occupation;

    /**
     * @var string
     *
     * @ORM\Column(name="hobbies1", type="string", length=255, nullable=true)
     */
    private $hobbies1;

    /**
     * @var string
     *
     * @ORM\Column(name="hobbies2", type="string", length=255, nullable=true)
     */
    private $hobbies2;

    /**
     * @var string
     *
     * @ORM\Column(name="hobbies3", type="string", length=255, nullable=true)
     */
    private $hobbies3;

    /**
     * @var string
     *
     * @ORM\Column(name="how_did_you_hear_about_us", type="string", length=100, nullable=false)
     */
    private $howDidYouHearAboutUs;

    /**
     * @var string
     *
     * @ORM\Column(name="marketing_followup", type="string", length=255, nullable=true)
     */
    private $marketingFollowup;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deceased_date", type="date", nullable=true)
     */
    private $deceasedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dismissed_date", type="date", nullable=true)
     */
    private $dismissedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="regdate", type="date", nullable=true)
     */
    private $regdate;

    /**
     * @var string
     *
     * @ORM\Column(name="pleaseCollect", type="string", length=10, nullable=true)
     */
    private $pleasecollect;

    /**
     * @var \MillerVein\EMRBundle\Entity\ReferringPhysician
     *
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\ReferringPhysician")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="referring_physician", referencedColumnName="id")
     * })
     */
    private $referringPhysician;

    /**
     * @var \MillerVein\EMRBundle\Entity\MarketingCampaign
     *
     * @ORM\ManyToOne(targetEntity="MillerVein\EMRBundle\Entity\MarketingCampaign")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marketing_campaign", referencedColumnName="id")
     * })
     */
    private $marketingCampaign;



    /**
     * Alias of getPid()
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->pid;
    }
    
    /**
     * Get pid
     *
     * @return integer 
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set pubpid
     *
     * @param string $pubpid
     * @return PatientData
     */
    public function setPubpid($pubpid)
    {
        $this->pubpid = $pubpid;

        return $this;
    }

    /**
     * Get pubpid
     *
     * @return string 
     */
    public function getPubpid()
    {
        return $this->pubpid;
    }

    /**
     * Set fname
     *
     * @param string $fname
     * @return PatientData
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
     * @return PatientData
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
     * @return PatientData
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
     * Set nickname
     *
     * @param string $nickname
     * @return PatientData
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return PatientData
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
     * Set dob
     *
     * @param \DateTime $dob
     * @return PatientData
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime 
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Set sex
     *
     * @param string $sex
     * @return PatientData
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
     * Set street
     *
     * @param string $street
     * @return PatientData
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
     * @return PatientData
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
     * Set county
     *
     * @param string $county
     * @return PatientData
     */
    public function setCounty($county)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return string 
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return PatientData
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
     * @return PatientData
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
     * Set phoneHome
     *
     * @param string $phoneHome
     * @return PatientData
     */
    public function setPhoneHome($phoneHome)
    {
        $this->phoneHome = $phoneHome;

        return $this;
    }

    /**
     * Get phoneHome
     *
     * @return string 
     */
    public function getPhoneHome()
    {
        return $this->phoneHome;
    }

    /**
     * Set phoneBiz
     *
     * @param string $phoneBiz
     * @return PatientData
     */
    public function setPhoneBiz($phoneBiz)
    {
        $this->phoneBiz = $phoneBiz;

        return $this;
    }

    /**
     * Get phoneBiz
     *
     * @return string 
     */
    public function getPhoneBiz()
    {
        return $this->phoneBiz;
    }

    /**
     * Set phoneCell
     *
     * @param string $phoneCell
     * @return PatientData
     */
    public function setPhoneCell($phoneCell)
    {
        $this->phoneCell = $phoneCell;

        return $this;
    }

    /**
     * Get phoneCell
     *
     * @return string 
     */
    public function getPhoneCell()
    {
        return $this->phoneCell;
    }

    /**
     * Set bestNumber
     *
     * @param string $bestNumber
     * @return PatientData
     */
    public function setBestNumber($bestNumber)
    {
        $this->bestNumber = $bestNumber;

        return $this;
    }

    /**
     * Get bestNumber
     *
     * @return string 
     */
    public function getBestNumber()
    {
        return $this->bestNumber;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return PatientData
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
     * Set emergencyName
     *
     * @param string $emergencyName
     * @return PatientData
     */
    public function setEmergencyName($emergencyName)
    {
        $this->emergencyName = $emergencyName;

        return $this;
    }

    /**
     * Get emergencyName
     *
     * @return string 
     */
    public function getEmergencyName()
    {
        return $this->emergencyName;
    }

    /**
     * Set emergencyNumber
     *
     * @param string $emergencyNumber
     * @return PatientData
     */
    public function setEmergencyNumber($emergencyNumber)
    {
        $this->emergencyNumber = $emergencyNumber;

        return $this;
    }

    /**
     * Get emergencyNumber
     *
     * @return string 
     */
    public function getEmergencyNumber()
    {
        return $this->emergencyNumber;
    }

    /**
     * Set hipaaMail
     *
     * @param boolean $hipaaMail
     * @return PatientData
     */
    public function setHipaaMail($hipaaMail)
    {
        $this->hipaaMail = $hipaaMail;

        return $this;
    }

    /**
     * Get hipaaMail
     *
     * @return boolean 
     */
    public function getHipaaMail()
    {
        return $this->hipaaMail;
    }

    /**
     * Set hipaaEmail
     *
     * @param boolean $hipaaEmail
     * @return PatientData
     */
    public function setHipaaEmail($hipaaEmail)
    {
        $this->hipaaEmail = $hipaaEmail;

        return $this;
    }

    /**
     * Get hipaaEmail
     *
     * @return boolean 
     */
    public function getHipaaEmail()
    {
        return $this->hipaaEmail;
    }

    /**
     * Set hipaaCellPhone
     *
     * @param boolean $hipaaCellPhone
     * @return PatientData
     */
    public function setHipaaCellPhone($hipaaCellPhone)
    {
        $this->hipaaCellPhone = $hipaaCellPhone;

        return $this;
    }

    /**
     * Get hipaaCellPhone
     *
     * @return boolean 
     */
    public function getHipaaCellPhone()
    {
        return $this->hipaaCellPhone;
    }

    /**
     * Set hipaaHomePhone
     *
     * @param boolean $hipaaHomePhone
     * @return PatientData
     */
    public function setHipaaHomePhone($hipaaHomePhone)
    {
        $this->hipaaHomePhone = $hipaaHomePhone;

        return $this;
    }

    /**
     * Get hipaaHomePhone
     *
     * @return boolean 
     */
    public function getHipaaHomePhone()
    {
        return $this->hipaaHomePhone;
    }

    /**
     * Set hipaaWorkPhone
     *
     * @param boolean $hipaaWorkPhone
     * @return PatientData
     */
    public function setHipaaWorkPhone($hipaaWorkPhone)
    {
        $this->hipaaWorkPhone = $hipaaWorkPhone;

        return $this;
    }

    /**
     * Get hipaaWorkPhone
     *
     * @return boolean 
     */
    public function getHipaaWorkPhone()
    {
        return $this->hipaaWorkPhone;
    }

    /**
     * Set hipaaVoicemail
     *
     * @param boolean $hipaaVoicemail
     * @return PatientData
     */
    public function setHipaaVoicemail($hipaaVoicemail)
    {
        $this->hipaaVoicemail = $hipaaVoicemail;

        return $this;
    }

    /**
     * Get hipaaVoicemail
     *
     * @return boolean 
     */
    public function getHipaaVoicemail()
    {
        return $this->hipaaVoicemail;
    }

    /**
     * Set occupation
     *
     * @param string $occupation
     * @return PatientData
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return string 
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set hobbies1
     *
     * @param string $hobbies1
     * @return PatientData
     */
    public function setHobbies1($hobbies1)
    {
        $this->hobbies1 = $hobbies1;

        return $this;
    }

    /**
     * Get hobbies1
     *
     * @return string 
     */
    public function getHobbies1()
    {
        return $this->hobbies1;
    }

    /**
     * Set hobbies2
     *
     * @param string $hobbies2
     * @return PatientData
     */
    public function setHobbies2($hobbies2)
    {
        $this->hobbies2 = $hobbies2;

        return $this;
    }

    /**
     * Get hobbies2
     *
     * @return string 
     */
    public function getHobbies2()
    {
        return $this->hobbies2;
    }

    /**
     * Set hobbies3
     *
     * @param string $hobbies3
     * @return PatientData
     */
    public function setHobbies3($hobbies3)
    {
        $this->hobbies3 = $hobbies3;

        return $this;
    }

    /**
     * Get hobbies3
     *
     * @return string 
     */
    public function getHobbies3()
    {
        return $this->hobbies3;
    }

    /**
     * Set howDidYouHearAboutUs
     *
     * @param string $howDidYouHearAboutUs
     * @return PatientData
     */
    public function setHowDidYouHearAboutUs($howDidYouHearAboutUs)
    {
        $this->howDidYouHearAboutUs = $howDidYouHearAboutUs;

        return $this;
    }

    /**
     * Get howDidYouHearAboutUs
     *
     * @return string 
     */
    public function getHowDidYouHearAboutUs()
    {
        return $this->howDidYouHearAboutUs;
    }

    /**
     * Set marketingFollowup
     *
     * @param string $marketingFollowup
     * @return PatientData
     */
    public function setMarketingFollowup($marketingFollowup)
    {
        $this->marketingFollowup = $marketingFollowup;

        return $this;
    }

    /**
     * Get marketingFollowup
     *
     * @return string 
     */
    public function getMarketingFollowup()
    {
        return $this->marketingFollowup;
    }

    /**
     * Set deceasedDate
     *
     * @param \DateTime $deceasedDate
     * @return PatientData
     */
    public function setDeceasedDate($deceasedDate)
    {
        $this->deceasedDate = $deceasedDate;

        return $this;
    }

    /**
     * Get deceasedDate
     *
     * @return \DateTime 
     */
    public function getDeceasedDate()
    {
        return $this->deceasedDate;
    }

    /**
     * Set dismissedDate
     *
     * @param \DateTime $dismissedDate
     * @return PatientData
     */
    public function setDismissedDate($dismissedDate)
    {
        $this->dismissedDate = $dismissedDate;

        return $this;
    }

    /**
     * Get dismissedDate
     *
     * @return \DateTime 
     */
    public function getDismissedDate()
    {
        return $this->dismissedDate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return PatientData
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set regdate
     *
     * @param \DateTime $regdate
     * @return PatientData
     */
    public function setRegdate($regdate)
    {
        $this->regdate = $regdate;

        return $this;
    }

    /**
     * Get regdate
     *
     * @return \DateTime 
     */
    public function getRegdate()
    {
        return $this->regdate;
    }

    /**
     * Set pleasecollect
     *
     * @param string $pleasecollect
     * @return PatientData
     */
    public function setPleasecollect($pleasecollect)
    {
        $this->pleasecollect = $pleasecollect;

        return $this;
    }

    /**
     * Get pleasecollect
     *
     * @return string 
     */
    public function getPleasecollect()
    {
        return $this->pleasecollect;
    }

    /**
     * Set referringPhysician
     *
     * @param \MillerVein\EMRBundle\Entity\ReferringPhysician $referringPhysician
     * @return PatientData
     */
    public function setReferringPhysician(\MillerVein\EMRBundle\Entity\ReferringPhysician $referringPhysician = null)
    {
        $this->referringPhysician = $referringPhysician;

        return $this;
    }

    /**
     * Get referringPhysician
     *
     * @return \MillerVein\EMRBundle\Entity\ReferringPhysician 
     */
    public function getReferringPhysician()
    {
        return $this->referringPhysician;
    }

    /**
     * Set marketingCampaign
     *
     * @param \MillerVein\EMRBundle\Entity\MarketingCampaign $marketingCampaign
     * @return PatientData
     */
    public function setMarketingCampaign(\MillerVein\EMRBundle\Entity\MarketingCampaign $marketingCampaign = null)
    {
        $this->marketingCampaign = $marketingCampaign;

        return $this;
    }

    /**
     * Get marketingCampaign
     *
     * @return \MillerVein\EMRBundle\Entity\MarketingCampaign 
     */
    public function getMarketingCampaign()
    {
        return $this->marketingCampaign;
    }
}
