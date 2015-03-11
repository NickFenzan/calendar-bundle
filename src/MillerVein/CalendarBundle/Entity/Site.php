<?php

namespace MillerVein\CalendarBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
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
     * Zip
     * @var string
     * @ORM\Column(length=10)
     * @Assert\Length(min = 5,max = 10)
     * @Assert\NotBlank()
     */
    protected $zip;
    /**
     * @OneToMany(targetEntity="Column", mappedBy="site" )
     * @var ArrayCollection 
     */
    protected $columns;
    
    public function __construct() {
        $this->columns = new ArrayCollection();
    }
    
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
    
    public function getColumns() {
        return $this->columns;
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

    public function setColumns(ArrayCollection $columns) {
        $this->columns = $columns;
    }

}
