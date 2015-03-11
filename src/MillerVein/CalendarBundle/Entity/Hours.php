<?php

namespace MillerVein\CalendarBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Sabre\VObject\Component\VCalendar;
use Sabre\VObject\Reader;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describes when the office is open and the length of the scheduling slots. 
 * These apply to Calendar\Columns. One should be able to link to many columns.
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity()
 * @ORM\Table("calendar_hours")
 */
class Hours {

// <editor-fold defaultstate="collapsed" desc="Properties">
    /**
     * Object Id
     * @var int ID
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue 
     */
    protected $id;

    /**
     * Descriptive name of hours rule
     * @var string 
     * @ORM\Column(length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     */
    protected $name;


    /**
     * Date hours take effect
     * @var DateTime 
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    protected $start_date;

    /**
     * Office opening time
     * @var DateTime
     * @Assert\NotBlank()
     * @Assert\Time() 
     * @ORM\Column(type="time")
     */
    protected $open_time;

    /**
     * Office closing time
     * @var DateTime 
     * @Assert\NotBlank()
     * @Assert\Time()
     * @ORM\Column(type="time")
     */
    protected $close_time;

    /**
     * The beginning of lunch
     * @var DateTime 
     * @Assert\NotBlank()
     * @Assert\Time()
     * @ORM\Column(type="time")
     */
    protected $lunch_start;

    /**
     * The end of lunch
     * @var DateTime 
     * @Assert\NotBlank()
     * @Assert\Time()
     * @ORM\Column(type="time")
     */
    protected $lunch_end;

    /**
     * Amount of minutes each slot takes up.
     * @var int
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min=5,
     *      max=240
     * )
     * @ORM\Column(type="smallint")
     */
    protected $scheduling_increment;

    /**
     * The Recurrance Rule
     * @var RecurranceRule
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="RecurranceRule", cascade={"persist"})
     */
    protected $recurrance_rule; // </editor-fold>

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

    public function getStartDate() {
        return $this->start_date;
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

    public function setStartDate(DateTime $start_date) {
        $this->start_date = $start_date;
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
        $this->scheduling_increment = $scheduling_increment;
    }

    public function setRecurranceRule(RecurranceRule $recurrance_rule) {
        $this->recurrance_rule = $recurrance_rule;
    }


// </editor-fold>

    /**
     * @Assert\True(message="Scheduling increment must be a multiple of 5")
     */
    public function isSchedulingIncrementValid(){
        if ($this->scheduling_increment % 5 !== 0){
            return false;
        }
    }
    
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
        $recurrance_rule = $this->recurrance_rule;
        
        //If the hours haven't taken effect yet bail
        if($this->start_date > $date){
            return false;
        }
        
        //If there isn't a recurrance rule associated the hours are always good
        if(null === $recurrance_rule){
            return true;
        }
        
        return $recurrance_rule->doesRuleApplyToDate($this->start_date, $date);
    }
    
}
