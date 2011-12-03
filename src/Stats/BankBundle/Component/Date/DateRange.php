<?php

namespace Stats\BankBundle\Component\Date;

class DateRange
{
    /**
     * Gets a date object with the first day of the month set.
     * 
     * @param int $month
     * @param int $year
     * @return \DateTime 
     * 
     * @throws IllegalArgumentException
     */
    public function withFirstDay($month, $year)
    {
        $this->checkMonth($month);
        
        return new \DateTime("$year-$month-01");
    }
    
    /**
     * Gets a date object with the last day of the month set.
     * @param int $month
     * @param int $year
     * @return \DateTime 
     * 
     * @throws IllegalArgumentException
     */
    public function withLastDay($month, $year)
    {
        $this->checkMonth($month);
        
        $d = date("t", strtotime("$year-$month-01") );
        return new \DateTime("$year-$month-$d");   
    }
    
    /**
     * @param type $month
     * 
     * @throws IllegalArgumentException if provided month is incorrect
     */
    public function checkMonth($month)
    {
        if($month < 1 || $month > 12)
        {
            throw new IllegalArgumentException("Illegal month value: $month. Should be between 1 and 12");
        }
    }
}