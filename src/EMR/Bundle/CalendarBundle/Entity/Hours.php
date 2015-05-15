<?php

namespace EMR\Bundle\CalendarBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EMR\Bundle\CalendarBundle\Model\HoursIterator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Describes when the office is open and the length of the scheduling slots. 
 * These apply to Calendar\Columns. One should be able to link to many columns.
 *
 * @author Nick Fenzan <nickf@millervein.com>
 * @ORM\Entity(repositoryClass="EMR\Bundle\CalendarBundle\Entity\Repository\HoursRepository")
 * @ORM\Table("calendar.hours")
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
     * Date hours take effect
     * @var DateTime 
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    protected $end_date;

    /**
     * Office opening time
     * @var DateTime
     * @ORM\Column(type="time", nullable=true)
     */
    protected $open_time;

    /**
     * Office closing time
     * @var DateTime 
     * @ORM\Column(type="time", nullable=true)
     */
    protected $close_time;

    /**
     * Lunch start
     * @var DateTime
     * @ORM\Column(type="time", nullable=true)
     */
    protected $lunch_start;

    /**
     * Lunch end
     * @var DateTime 
     * @ORM\Column(type="time", nullable=true)
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
     * The Recurrence Rule
     * @var RecurrenceRule
     * @Assert\Valid
     * @ORM\ManyToOne(targetEntity="RecurrenceRule", cascade={"persist"})
     */
    protected $recurrence_rule;

    /**
     * Regular hours of this column
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Column", mappedBy="hours")
     */
    protected $columns;

// </editor-fold>

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

    public function getEndDate() {
        return $this->end_date;
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

    public function hasLunch() {
        return ($this->lunch_start !== null && $this->lunch_end !== null);
    }

    public function getSchedulingIncrement() {
        return $this->scheduling_increment;
    }

    public function getSchedulingInterval() {
        return new \DateInterval('PT' . $this->scheduling_increment . 'M');
    }

    public function getRecurrenceRule() {
        return $this->recurrence_rule;
    }

    function getColumns() {
        return $this->columns;
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

    public function setEndDate(DateTime $end_date = null) {
        $this->end_date = $end_date;
    }

    public function setOpenTime(DateTime $open_time = null) {
        $this->open_time = $open_time;
    }

    public function setCloseTime(DateTime $close_time = null) {
        $this->close_time = $close_time;
    }

    public function setLunchStart(DateTime $lunch_start = null) {
        $this->lunch_start = $lunch_start;
    }

    public function setLunchEnd(DateTime $lunch_end = null) {
        $this->lunch_end = $lunch_end;
    }

    public function setSchedulingIncrement($scheduling_increment) {
        $this->scheduling_increment = $scheduling_increment;
    }

    public function setRecurrenceRule(RecurrenceRule $recurrence_rule) {
        $this->recurrence_rule = $recurrence_rule;
    }

    function setColumns(ArrayCollection $columns) {
        $this->columns = $columns;
    }

// </editor-fold>

    /**
     * @Assert\True(message="Scheduling increment must be a multiple of 5")
     */
    public function isSchedulingIncrementValid() {
        if ($this->scheduling_increment % 5 !== 0) {
            return false;
        }
    }

    /**
     * @Assert\True(message="End Date must be later than start date")
     */
    public function isEndDateValid() {
        if (null !== $this->end_date && $this->end_date < $this->start_date) {
            return false;
        }
    }

    public function doHoursApplyToDate(DateTime $date) {
        $recurrence_rule = $this->recurrence_rule;

        //If the hours haven't taken effect yet bail
        if ($this->start_date > $date) {
            return false;
        }

        //If the hours are expired bail
        if (null !== $this->end_date && $date > $this->end_date) {
            return false;
        }

        //If there isn't a recurrence rule associated the hours are always good
        if (null === $recurrence_rule) {
            return true;
        }

        return $recurrence_rule->doesRuleApplyToDate($this->start_date, $date);
    }

    public function doTimesConflict(\DateTime $start, \DateTime $end) {
        $start = new \DateTime($start->format('H:i'));
        $end = new \DateTime($end->format('H:i'));
        $openTime = new \DateTime($this->getOpenTime()->format('H:i'));
        $closeTime = new \DateTime($this->getCloseTime()->format('H:i'));
        if (is_a($hours->getLunchStart(), '\DateTime')) {
            $lunchStart = new \DateTime($this->getLunchStart()->format('H:i'));
        }
        if (is_a($hours->getLunchEnd(), '\DateTime')) {
            $lunchEnd = new \DateTime($this->getLunchEnd()->format('H:i'));
        }
        if (
        //Appointment starts before we are open
                $start < $openTime ||
                //Appointment ends after we are closed
                $end > $closeTime ||
                //Appointment starts during lunch
                ($start >= $lunchStart && $start < $lunchEnd) ||
                //Appointment starts before lunch, but doesnt end before lunch
                ($start <= $lunchStart && $end > $lunchStart)
        ) {
//            echo "true";
            return true;
        } else {
            return false;
        }
    }

    public function isOpen() {
        return ($this->open_time !== null && $this->close_time !== null);
    }

    public function getIterator() {
        return new HoursIterator($this);
    }

}
