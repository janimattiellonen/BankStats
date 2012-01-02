<?php

namespace Stats\BankBundle\Tests\component\Date;

use Stats\BankBundle\Component\Date\DateRange;


class DateRangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DateRange
     */
    protected $range;
    
    public function setUp()
    {
        $this->range = new DateRange();
    }
    
    /**
     * @test
     * @group date-range
     */
    public function testFirstDay()
    {
        $expected = new \DateTime("2011-11-01");
        
        $this->assertEquals($expected, $this->range->withFirstDay(11, 2011) );
    }
    
    /**
     * @test
     * @group date-range
     */
    public function testLastDay()
    {
        $expected = new \DateTime("2011-11-30");
        
        $this->assertEquals($expected, $this->range->withLastDay(11, 2011) );
    }
    
    /**
     * @test
     * @expectedException Stats\BankBundle\Component\Date\IllegalArgumentException
     * @dataProvider invalidMonths
     * 
     * 
     * @group date-range
     */
    public function exceptiosIsThrown($month)
    {
        $this->range->withFirstDay($month, 2011);
    }
 
    /**
     * @return array
     */
    public function invalidMonths()
    {
        return array(
            array(0),
            array(13),
        );
    }
}