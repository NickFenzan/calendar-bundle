<?php

namespace MillerVein\Bundle\CalendarBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Eluceo\iCal\Property\Event\RecurrenceRule as EluceoRecurranceRule;
use ReflectionClass;
use Sabre\VObject\Recur\RRuleIterator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rule that describes recurrence pattern based on 
 * @link https://tools.ietf.org/html/rfc5545 RFC5545
 *
 * @ORM\Entity()
 * @ORM\Table("calendar.recurrence_rule")
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RecurrenceRule extends EluceoRecurranceRule {

    /**
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * Name of the rule
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
     * The frequency of an Event
     *
     * @var string
     * @Assert\Choice(callback = "getFreqChoicesValidation")
     * @ORM\Column(type="string")
     */
    protected $freq = self::FREQ_YEARLY;

    /**
     * @var null|int
     * @Assert\Range(min = 1)
     * @ORM\Column(name="interv",type="integer", nullable=true)
     */
    protected $interval = 1;

    /**
     *
     * @var DateTime
     * @Assert\Date()
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $until;

    /**
     * @var null|int
     * @Assert\Range(min = 1)
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $count = null;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byMonth;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byWeekNo;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byYearDay;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byDay;

// <editor-fold defaultstate="collapsed" desc="Getters">
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getUntil() {
        return $this->until;
    }

    public function setUntil(DateTime $until = null) {
        $this->until = $until;
    }

    public function getByDay() {
        return $this->byDay;
    }

    public function getByMonth() {
        return $this->byMonth;
    }

    /**
     * 
     * @return Array|null Array of months 1-12
     */
    public function getByMonthArray() {
        if (null === $this->getByMonth()) {
            return null;
        } else {
            return split(",", $this->getByMonth());
        }
    }

    public function getByWeekNo() {
        return $this->byWeekNo;
    }

    public function getByYearDay() {
        return $this->byYearDay;
    }

    public function getByMonthDay() {
        return $this->byMonthDay;
    }

    // </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Setters">
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setByMonth($month) {

//        if (!is_integer($month) || $month < 0 || $month > 12) {
//            throw new InvalidArgumentException('Invalid value for BYMONTH');
//        }

        $this->byMonth = $month;
        return $this;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Validation Checks">
    /**
     * @Assert\True(message="By month contains an invalid value")
     */
    public function isByMonthValid() {
        if (null === $this->byMonth) {
            return true;
        }
        $array = split(",", $this->byMonth);
        foreach ($array as $val) {
            if ($val < 1 || $val > 12 || !is_numeric($val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Assert\True(message="By week number contains an invalid value")
     */
    public function isByWeekNoValid() {
        if (null === $this->byWeekNo) {
            return true;
        }
        if ($this->freq !== self::FREQ_YEARLY) {
            return false;
        }
        $array = split(",", $this->byWeekNo);
        foreach ($array as $val) {
            if (abs($val) > 53 || $val == 0 || !is_int($val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Assert\True(message="By year day contains an invalid value")
     */
    public function isByYearDayValid() {
        if (null === $this->byYearDay) {
            return true;
        }
        if ($this->freq !== self::FREQ_YEARLY) {
            return false;
        }
        $array = split(",", $this->byYearDay);
        foreach ($array as $val) {
            if (abs($val) > 366 || $val == 0 || !is_int($val)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @Assert\True(message="By day contains an invalid value")
     */
    public function isByDayValid() {
        if (null === $this->byDay) {
            return true;
        }
        $array = split(",", $this->byDay);
        foreach ($array as $val) {
            if (in_array($this->freq, [self::FREQ_YEARLY, self::FREQ_MONTHLY])) {
                if (!preg_match("/^(\+\d|\-\d)?(MO|TU|WE|TH|FR|SA|SU)$/", $val)) {
                    return false;
                }
            } else {
                if (!preg_match("/^(MO|TU|WE|TH|FR|SA|SU)$/", $val)) {
                    return false;
                }
            }
        }

        return true;
    }

// </editor-fold>
// <editor-fold defaultstate="collapsed" desc="Overrides">
    protected function buildParameterBag() {
        $parameterBag = parent::buildParameterBag();
        if (null !== $this->until) {
            $parameterBag->setParam('UNTIL', $this->until->format("Ymd\THis\Z"));
        }
        return $parameterBag;
    }

// </editor-fold>

    public function doesRuleApplyToDate(DateTime $startDate, DateTime $date) {
        $iter = new RRuleIterator($this->getEscapedValue(), $startDate);
        $iter->fastForward($date);
        return ($iter->current() == $date);
    }

// <editor-fold defaultstate="collapsed" desc="Statics">
    public static function getFreqChoices() {
        $refl = new ReflectionClass('MillerVein\Bundle\CalendarBundle\Entity\RecurrenceRule');
        $array = array();
        foreach ($refl->getConstants() as $constant => $value) {
            if (preg_match("/^FREQ/", $constant)) {
                $array[$value] = ucfirst(strtolower($value));
            }
        }
        return $array;
    }

    public static function getFreqChoicesValidation() {
        return array_flip(self::getFreqChoices());
    }

// </editor-fold>
}
