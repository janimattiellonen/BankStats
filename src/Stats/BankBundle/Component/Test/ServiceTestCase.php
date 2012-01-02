<?php
namespace Stats\BankBundle\Component\Test;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServiceTestCase extends WebTestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        
        $this->container = $kernel->getContainer();
    }
    
    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}