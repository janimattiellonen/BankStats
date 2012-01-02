<?php

namespace Stats\BankBundle\Tests\Model;

use Stats\BankBundle\Model\Statistics;

class StatisticsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Stats
     */
    private $stats;
    
    public function setUp()
    {
        $this->stats = new Statistics($this->createTestData() );
    }
    
    /**
     * @return array
     */
    protected function createTestData()
    {
        return array(
            'deposits' => 1112.67,
            'withdrawals' => 1567.90,
            'month' => 11,
            'year' => 2011,
        );
    }
    
    public function invalidValues()
    {
        return array(
            array(array(
            'withdrawals' => 1567.90,
            'month' => 11,
            'year' => 2011,
            ) ),
            array(array(
            'deposits' => 1112.67,
            'month' => 11,
            'year' => 2011,
            ) ),   
            array(array(
            'deposits' => 1112.67,
            'withdrawals' => 1567.90,
            'year' => 2011,
            ) ),
            array(array(
            'deposits' => 1112.67,
            'withdrawals' => 1567.90,
            'month' => 11,
            ) ),
        );
    }
    
    /**
     * @test
     * 
     * @group model
     * @group stats
     */
    public function yieldsCorrectDailySpending()
    {
       $avg = $this->stats->calculateAverageDailySpending();
       $expected = 52.2633;
       
       $this->assertEquals($expected, round($avg, 4) );
    }
    
    /**
     * @test
     * @dataProvider invalidValues
     * 
     * @group stats
     * 
     * @expectedException Stats\BankBundle\Model\IllegalArgumentException
     */
    public function dailySpendingThrowsException(array $data)
    {
        $stats = new Statistics($data);
        $stats->calculateAverageDailySpending();
    }
}