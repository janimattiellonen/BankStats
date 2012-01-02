<?php
namespace Stats\BankBundle\Tests\Component\Csv;

use Stats\Component\Csv\Parser;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     * @var Parser 
     */
    protected $parser;
    
    /**
     *
     * @var string
     */
    protected $csvFile;
    
    public function setUp()
    {
        ini_set('auto_detect_line_endings', true);
        $this->csvFile = dirname(__FILE__) . '/test.csv';
        
        
        $this->parser = new Parser("\t");
    }
    
    /**
     * @test
     * @group csv
     */
    public function testHasCorrectData()
    {
        $data = $this->parser->parse(file_get_contents($this->csvFile) );
        
        $this->assertEquals($this->getExpectedResult(), $data);
    }
    
    /**
     * @return array
     */
    protected function getExpectedResult()
    {
        return array(
            'header' => array(
                'Kirjauspäivä',	
                'Arvopäivä',	
                'Maksupäivä', 
                'Määrä',	
                'Saaja/Maksaja',	
                'Tilinumero',	
                'BIC',	
                'Tapahtuma',	
                'Viite',	
                'Maksajan viite',	
                'Viesti',	
                'Kortinnumero',	
                'Kuitti',	
            ),
            'content' => array(
                array('22.02.2010', '22.02.2010', '22.02.2010', '-7,2', 'WAYNES COFFEE 00100 HELSINKI', '', '', 'Korttiosto', '200219101208', '', '', '4964190075386124', ''),		
                array('22.02.2010', '22.02.2010', '22.02.2010', '-7,8', 'SUBWAY SELLO 00970 HELSINKI', '', '', 'Korttiosto', '200219101208', '', '', '4964190075386124', ''),		
                array('22.02.2010', '22.02.2010', '22.02.2010', '-49,8', 'EB GAMES FINLAND OY', '', '', 'Korttiosto', '200219101208', '', '', '4964190075386124', ''),		
            ),  
        );
    }
}