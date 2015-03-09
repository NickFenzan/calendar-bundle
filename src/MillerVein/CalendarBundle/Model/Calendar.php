<?php

namespace MillerVein\CalendarBundle\Model;

/**
 * Description of Calendar
 *
 * @author Nick Fenzan <nickf@millervein.com>
 */
class Calendar {
    /**
     * Date calendar is to display
     * @var \DateTime
     */
    protected $date;
    /**
     * Columns calendar is to display
     * @var Array
     */
    protected $columns;
    
    public function __construct(\DateTime $date, Array $columns) {
        $this->date = $date;
        $this->buildColumns($columns);
    }
    
    public function getDate() {
        return $this->date;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function setDate(\DateTime $date) {
        $this->date = $date;
    }

    public function setColumns(Array $columns) {
        $this->buildColumns($columns);
    }

    protected function buildColumns(Array $columns){
        $this->columns = array();
        foreach($columns as $column){
            if(is_a($column,"MillerVein\CalendarBundle\Entity\Column")){
                $this->columns[] = new CalendarColumn($column, $this->date);
            }else{
                throw new \Exception("Columns array contains non-column objects");
            }
        }
    }

}
