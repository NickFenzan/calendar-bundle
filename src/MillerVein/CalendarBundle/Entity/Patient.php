<?php
namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Patient
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity(repositoryClass="MillerVein\CalendarBundle\Entity\PatientRepository")
 */
class Patient {
    /**
     * Patient ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * First Name
     * @var string
     * @Assert\NotBlank() 
     * @ORM\Column(type="string")
     */
    protected $fname;
    
    /**
     * Last Name
     * @var string
     * @Assert\NotBlank() 
     * @ORM\Column(type="string")
     */
    protected $lname;
    
    /**
     * DOB
     * @var \DateTime
     * @Assert\NotBlank() 
     * @ORM\Column(type="date")
     */
    protected $dob;
    
    public function getId() {
        return $this->id;
    }

    public function getFname() {
        return $this->fname;
    }

    public function getLname() {
        return $this->lname;
    }

    public function getDob() {
        return $this->dob;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFname($fname) {
        $this->fname = $fname;
    }

    public function setLname($lname) {
        $this->lname = $lname;
    }

    public function setDob(\DateTime $dob) {
        $this->dob = $dob;
    }


}
