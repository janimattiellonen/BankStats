<?php
namespace Stats\BankBundle\Model;

use Stats\BankBundle\Model\Statistics\Entry;

class Statistics
{
    /**
     * @var array
     */
    private $data;
    
    /**
     * @param array $data 
     */
    public function __construct(array $data = array() )
    {
        if(!isset($data['withdrawals']) )
        {
            $data['withdrawals'] = 0;
        }
        
        if(!isset($data['deposits']) )
        {
            $data['deposits'] = 0;
        }
        
        $this->data = $data;
    }

    /**
     * @throws IllegalArgumentException
     */
    protected function checkInput()
    {
        $required = array(
            'withdrawals',
            'deposits',
            'month',
            'year',
        );
        
        foreach($required as $value)
        {
            if(!isset($this->data[$value]) )
            {
                throw new IllegalArgumentException("Missing value: $value");
            }
        }
    }
    
    /**
     * @return double
     */
    public function calculateAverageDailySpending()
    {
        $this->checkInput();
        
        $year = $this->data['year'];
        $month = $this->data['month'];
        $withdrawals = $this->data['withdrawals'];
        
        $days = date('t', strtotime("$year-$month-01") );
        
        return number_format($withdrawals / $days, 2);
    }
    
    /**
     * @return dobule
     */
    public function calculateDifference()
    {
        $withdrawals = (double)$this->data['withdrawals'];
        $deposits = (double)$this->data['deposits'];
        
        return number_format($deposits - abs($withdrawals), 2);
    }
    
}