<?php

namespace MillerVein\CalendarBundle\Entity;

use DateTime;
use Exception;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use MillerVein\CalendarBundle\Entity\RecurranceRule;

/**
 * Describes when the office is open and the length of the scheduling slots. 
 * These apply to Calendar\Columns. One should be able to link to many columns.
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity(repositoryClass="HoursRepository")
 * @ORM\Table("calendar_hours")
 */
class Hours {

    /**
     * Object Id
     * @var int ID
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue 
     */
    protected $id;

    /**
     * @*ORM\ManyToMany(targetEntity="Column", inversedBy="hours")
     * @*ORM\JoinTable(name="calendar_column_hours")
     * @var Array
     */
    protected $columns;

    /**
     * Descriptive name of hours rule
     * @var string 
     * @ORM\Column(length=50)
     * @Assert\NotNull()
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    protected $name;

    /**
     * Office opening time
     * @var DateTime
     * @Assert\Time() 
     * @ORM\Column(type="time")
     */
    protected $open_time;

    /**
     * Office closing time
     * @var DateTime 
     * @Assert\Time()
     * @ORM\Column(type="time")
     */
    protected $close_time;

    /**
     * The beginning of lunch
     * @var DateTime 
     * @Assert\Time()
     * @ORM\Column(type="time")
     */
    protected $lunch_start;

    /**
     * The end of lunch
     * @var DateTime 
     * @Assert\Time()
     * @ORM\Column(type="time")
     */
    protected $lunch_end;

    /**
     * Amount of minutes each slot takes up.
     * @var int
     * @Assert\Range(
     *      min=5,
     *      max=240
     * )
     * @ORM\Column(type="smallint")
     */
    protected $scheduling_increment;

    /**
     * The Recurrance Rule
     * @var MillerVein\CalendarBundle\Entity\RecurranceRule
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="MillerVein\CalendarBundle\Entity\RecurranceRule")
     */
    protected $recurrance_rule;

    public function __construct() {
        $this->columns = new ArrayCollection();
    }

// <editor-fold defaultstate="collapsed" desc="Property Getters">
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getOpenTime() {
        return $this->open_time;
    }

    public function getCloseTime() {
        return $this->close_time;
    }

    public function getLunchStart() {
        return $this->lunch_start;
    }

    public function getLunchEnd() {
        return $this->lunch_end;
    }

    public function getSchedulingIncrement() {
        return $this->scheduling_increment;
    }

    public function getRecurranceRule() {
        return $this->recurrance_rule;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Property Setters">
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setOpenTime(DateTime $open_time) {
        $this->open_time = $open_time;
    }

    public function setCloseTime(DateTime $close_time) {
        $this->close_time = $close_time;
    }

    public function setLunchStart(DateTime $lunch_start) {
        $this->lunch_start = $lunch_start;
    }

    public function setLunchEnd(DateTime $lunch_end) {
        $this->lunch_end = $lunch_end;
    }

    public function setSchedulingIncrement($scheduling_increment) {
        if(is_int($scheduling_increment)){
            $this->scheduling_increment = $scheduling_increment;
        }else{
            throw new Exception("Scheduling increment must be an interger. "
                    . "'$scheduling_increment' passed.");
        }
    }

    public function setRecurrance_rule(RecurranceRule $recurrance_rule) {
        $this->recurrance_rule = $recurrance_rule;
    }


// </editor-fold>

    public function getTimeSlotCount() {
        $openMinutes = ($this->close_time->getTimestamp() - $this->open_time->getTimestamp())/60;
        if($openMinutes % $this->scheduling_increment !== 0){
            throw new Exception("The time slots do not divide evenly into "
                    . "the time the office is open.");
        }else{
            return $openMinutes / $this->scheduling_increment;
        }
    }

    public function doHoursApplyToDate(DateTime $date){
            
        return true;
    }
    
}
