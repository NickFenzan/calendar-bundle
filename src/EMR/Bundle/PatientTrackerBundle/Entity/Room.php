<?php

namespace EMR\Bundle\PatientTrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EMR\Bundle\LegacyBundle\Entity\Site;

/**
 * Description of Room
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity(repositoryClass="RoomRepository")
 * @ORM\Table(name="calendar.room")
 */
class Room {
    /**
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @var string
     * @ORM\Column()
     */
    protected $name;
    /**
     * @var Site
     * @ORM\ManyToOne(targetEntity="\EMR\Bundle\LegacyBundle\Entity\Site")
     */
    protected $site;
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getSite() {
        return $this->site;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setSite(Site $site) {
        $this->site = $site;
    }

}
