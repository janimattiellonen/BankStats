<?php
namespace Stats\BankBundle\Service;

use Doctrine\ORM\EntityManager,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Form\Form,
    Stats\BankBundle\Entity\AccountStatement,
    Stats\BankBundle\Form\AccountStatementType;
    

class AccountService
{
    /**
     * @var EntityManager 
     */
    private $em;
    
    /**
     *
     * @var FormFactory 
     */
    private $factory;
    
    /**
     * @param EntityManager $em
     * @param FormFactory $factory 
     */
    public function __construct(EntityManager $em, FormFactory $factory)
    {
        $this->em = $em;
        $this->factory = $factory;
    }
    
    /**
     *
     * @param AccountStatement $accountStatement
     * @return Form
     */
    public function getAccountStatementForm(AccountStatement $accountStatement)
    {
        return $this->factory->create(
                new AccountStatementType(get_class($accountStatement) ), $accountStatement
        );
    }
    
}