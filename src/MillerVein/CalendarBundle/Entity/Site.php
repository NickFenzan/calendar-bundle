<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of Site
 * @ORM\Entity()
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Site {
    /**
     * Site ID
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * Street address
     * @var string
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $street;
    /**
     * City
     * @var string
     * @ORM\Column()
     * @Assert\NotBlank()
     */
    protected $city;
    /**
     * State
     * @var string
     * @ORM\Column(length=2)
     * @Assert\Length(min = 2,max = 2)
     * @Assert\NotBlank()
     */
    protected $state;
    /**
     * State
     * @var string
     * @ORM\Column(length=10)
     * @Assert\Length(min = 5,max = 10)
     * @Assert\NotBlank()
     */
    protected $zip;
    
    public function getId() {
        return $this->id;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }


}
