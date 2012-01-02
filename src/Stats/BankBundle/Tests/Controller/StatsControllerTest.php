<?php
namespace Stats\BankBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Symfony\Component\HttpFoundation\File\UploadedFile;

class StatsControllerTest extends WebTestCase
{
    /**
     * @var string
     */
    private $uploadDir;
    
    /**
     *
     * @var string
     */
    private $validFile;
    
    /**
     *
     * @var string
     */
    private $invalidFile;    
     
    /**
     *
     * @var string
     */
    private $invalidCsvFile;
    
    /**
     *
     * @var string
     */
    private $validSourceFile;
    
    /**
     *
     * @var string
     */
    private $invalidSourceFile;  
    
    /**
     *
     * @var string
     */
    private $invalidCsvSourceFile; 
    
    public function setUp()
    {
        $this->uploadDir = dirname(__FILE__) . '/tmp';
        $this->invalidFile = dirname(__FILE__) . '/tmp/image.jpg';
        $this->invalidCsvFile = dirname(__FILE__) . '/tmp/invalid.csv';
        $this->validFile = dirname(__FILE__) . '/tmp/test.csv';
        
        
        $this->invalidSourceFile = dirname(__FILE__) . '/data/image.jpg';
        $this->validSourceFile = dirname(__FILE__) . '/data/test.csv';
        $this->invalidCsvSourceFile = dirname(__FILE__) . '/data/invalid.csv';
        
        copy($this->validSourceFile, $this->validFile);
        copy($this->invalidSourceFile, $this->invalidFile);
        copy($this->invalidCsvSourceFile, $this->invalidCsvFile);
    }
    
    /**
     * @test
     * @group
     */
    public function testSelectFile()
    {
        $crawler = $client->request('GET', '/stats/select-file');

        $this->assertTrue($crawler->filter('html:contains("form[attachment]")')->count() > 0);
        $this->assertTrue($crawler->filter('html:contains("form_attachment")')->count() > 0);
    }
    
    /**
     * @test
     * @group controller
     */
    public function uploadFileWithAcceptedMimeType()
    {
        $client = static::createClient();
        
        $file = new UploadedFile(
            $this->validFile,
            'test.csv',
            'text/csv',
            filesize($this->validFile)
        );
        
        $crawler = $client->request(
            'POST',
            '/stats/upload',
            array(),
            array('form' => array('attachment' => $file))
        );
        
        $this->assertTrue($crawler->filter('html:contains("File was successfully uploaded")')->count() > 0);
    }
    
    /**
     * @test
     * @group controller
     */
    public function uploadFileWithDeniedMimeType()
    {
        $client = static::createClient();
        
        $file = new UploadedFile(
            $this->invalidFile,
            'test.csv',
            'text/csv',
            filesize($this->invalidFile)
        );
        
        $crawler = $client->request(
            'POST',
            '/stats/upload',
            array(),
            array('form' => array('attachment' => $file))
        );
        
        $this->assertFalse($crawler->filter('html:contains("File was successfully uploaded")')->count() > 0);
    }
    
    /**
     * @test
     * @group controller
     */
    public function uploadInvalidCsv()
    {
        $client = static::createClient();
        
        $file = new UploadedFile(
            $this->invalidCsvFile,
            'test.csv',
            'text/csv',
            filesize($this->invalidCsvFile)
        );
        
        $crawler = $client->request(
            'POST',
            '/stats/upload',
            array(),
            array('form' => array('attachment' => $file))
        );
        
        $this->assertFalse($crawler->filter('html:contains("File was successfully uploaded")')->count() > 0);
    }
}