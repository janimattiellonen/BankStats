<?php
namespace Stats\BankBundle\Test\Component\Validator;

use Stats\BankBundle\Component\Validator\AccountValidator,
    Stats\BankBundle\Component\Test\ServiceTestCase,
    Stats\BankBundle\Entity\AccountStatement;

class AccountValidatorTest extends ServiceTestCase
{
    /**
     * @var AccountValidator
     */
    private $validator;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->validator = $this->getContainer()->get('stats.accountValidator');
    }
    
    
    public function validData()
    {
        $as = new AccountStatement();
        $as->setEntryDate("22.02.2010")
           ->setValueDate("22.02.2010")
           ->setPaymentDate("22.02.2010")
           ->setAmount(-7.2)
           ->setReceiver("Loso poski Oy, 00100 Helsinki")
           ->setAccountNumber(null)
           ->setBic(null)
           ->setEvent("Korttiosto")
           ->setReferenceNumber("8576567456")
           ->setPayerReferenceNumber("35743854545")
           ->setMessage("Loso viesti")
           ->setCardNumber("4964190075386124")
           ->setReceipt(null);
        
        
        return array(
            array($as)
        );
    }
    
    /**
     * @test
     * @group component
     * @group validator
     * @group account
     * 
     * @dataProvider validData
     * 
     */
    public function validates($accountStatement)
    {
        $this->assertTrue($this->validator->validate($accountStatement) );
    }
}

// 22.02.2010	22.02.2010	22.02.2010	-7,2	WAYNES COFFEE  00100 HELSINKI			Korttiosto	200219101208			4964190075386124