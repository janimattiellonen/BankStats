<?php

namespace Stats\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="accountstatement")
 * @ORM\Entity(repositoryClass="Stats\BankBundle\Repository\AccountStatementRepository")
 */
class AccountStatement
{
    /**
     * @var integer
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="entry_date", type="date")
     * @Assert\Date()
     */
    protected $entryDate;
    
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="value_date", type="date")
     * @Assert\Date()
     */    
    protected $valueDate;
    
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="payment_date", type="date")
     * @Assert\Date()
     */    
    protected $paymentDate;
    
    /**
     * @var float
     * 
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2) 
     */
    protected $amount;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="receiver", type="string", length=128)
     */
    protected $receiver;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="account_number", type="string", length=128)
     */
    protected $accountNumber;
    
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="bic", type="string", length=128)
     */
    protected $bic;
    
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="event", type="string", length=128)
     */    
    protected $event;
    
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="reference_number", type="string", length=128)
     */    
    protected $referenceNumber;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="payment_reference_number", type="string", length=128)
     */    
    protected $payerReferenceNumber;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="message", type="text")
     */    
    protected $message;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="card_number", type="string", length=64)
     */        
    protected $cardNumber;
    
    /**
     * @var string 
     * 
     * @ORM\Column(name="receipt", type="string", length="5")
     */    
    protected $receipt;
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getEntryDate()
    {
        return $this->entryDate;
    }

    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
        
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getValueDate()
    {
        return $this->valueDate;
    }

    public function setValueDate($valueDate)
    {
        $this->valueDate = $valueDate;
        
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
        
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        
        return $this;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
        
        return $this;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
        
        return $this;
    }

    public function getBic()
    {
        return $this->bic;
    }

    public function setBic($bic)
    {
        $this->bic = $bic;
        
        return $this;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
        
        return $this;
    }

    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
        
        return $this;
    }

    public function getPayerReferenceNumber()
    {
        return $this->payerReferenceNumber;
    }

    public function setPayerReferenceNumber($payerReferenceNumber)
    {
        $this->payerReferenceNumber = $payerReferenceNumber;
        
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        
        return $this;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
        
        return $this;
    }

    public function getReceipt()
    {
        return $this->receipt;
    }

    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
        
        return $this;
    }
}