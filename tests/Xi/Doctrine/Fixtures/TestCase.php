<?php
namespace Xi\Doctrine\Fixtures;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $testDb;
    
    // Some fields public to allow access from the broken 5.3 closures.
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    public $em;
    
    /**
     * @var FixtureFactory
     */
    public $factory;
    
    public function setUp()
    {
        parent::setUp();
        $this->testDb = TestDb::get();
        $this->em = $this->testDb->createEntityManager();
        
        $this->factory = new FixtureFactory($this->em);
        $this->factory->setEntityNamespace('Xi\Doctrine\Fixtures\TestEntity');
    }
    
    /**
     * @return Exception
     */
    protected function assertThrows($func, $exceptionType = '\Exception')
    {
        try {
            $func();
        } catch (\Exception $e) {
        }
        if (!isset($e)) {
            $this->fail("Expected $exceptionType but nothing was thrown");
        }
        if ($e instanceof \PHPUnit_Framework_Error) {
            $this->fail('Expected exception but got a PHP error: ' . $e->getMessage());
        }
        if (!($e instanceof $exceptionType)) {
            $this->fail("Excpected $exceptionType but " . get_class($e) . " was thrown");
        }
        return $e;
    }
}
