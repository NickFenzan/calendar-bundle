<?php
namespace MillerVein\CalendarBundle\Entity;

use Eluceo\iCal\Property\Event\RecurrenceRule as EluceoRecurranceRule;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Rule that describes recurrance pattern based on 
 * @link https://tools.ietf.org/html/rfc5545 RFC5545
 *
 * @ORM\Entity()
 * @author Nick Fenzan <nickf@millervein.com>
 */
class RecurranceRule extends EluceoRecurranceRule {

    /**
     * @var int 
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    
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
     * @var \DateTime
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
     * I'm not using this right now so I am making sure it is always null
     * @var null|string
     * @Assert\Null()
     * @ORM\Column(type="string", nullable=true)
     */
    protected $wkst;

    /**
     * Validation is performed on a getter method
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
    protected $byMonthDay;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byDay;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byHour;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $byMinute;

    
    public function getUntil(){
        return $this->until;
    }
    public function setUntil(\DateTime $until = null){
        $this->until = $until;
    }
    public function getByDay(){
        return $this->byDay;
    }
    public function getByMonth(){
        return $this->byMonth;
    }
    /**
     * 
     * @return Array|null Array of months 1-12
     */
    public function getByMonthArray(){
        if(null === $this->getByMonth()){
            return null;
        }else{
            return split(",",$this->getByMonth());
        }
        
    }
    public function getByWeekNo(){
        return $this->byWeekNo;
    }
    public function getByYearDay(){
        return $this->byYearDay;
    }
    public function getByMonthDay(){
        return $this->byMonthDay;
    }
    
    protected function buildParameterBag() {
        $parameterBag = parent::buildParameterBag();
        if (null !== $this->until) {
            $parameterBag->setParam('UNTIL',$this->until->format("Ymd\THis\Z"));
        }
        return $parameterBag;
    }

    public static function getFreqChoices(){
        $refl = new \ReflectionClass('MillerVein\CalendarBundle\Entity\RecurranceRule');
        $array = array();
        foreach ($refl->getConstants() as $constant => $value) {
            if (preg_match("/^FREQ/", $constant)) {
                $array[$value] = ucfirst(strtolower($value));
            }
        }
        return $array;
    }
    public static function getFreqChoicesValidation(){
        return array_flip(self::getFreqChoices());
    }
    
    public function setByMonth($month) {
        
//        if (!is_integer($month) || $month < 0 || $month > 12) {
//            throw new InvalidArgumentException('Invalid value for BYMONTH');
//        }

        $this->byMonth = $month;
        return $this;
    }


}
