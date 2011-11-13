<?php

namespace BankStats\BankBundle\Entity;

use Doctrine\ORM\Mapping as ORM,
    Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="accountstatement")
 * @ORM\Entity()
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
     */
    protected $entryDate;
    
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="value_date", type="date")
     */    
    protected $valueDate;
    
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(name="payment_date", type="date")
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
     * @var tystringpe 
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

    public function getEntryDate()
    {
        return $this->entryDate;
    }

    public function setEntryDate($entryDate)
    {
        $this->entryDate = $entryDate;
    }

    public function getValueDate()
    {
        return $this->valueDate;
    }

    public function setValueDate($valueDate)
    {
        $this->valueDate = $valueDate;
    }

    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getReceiver()
    {
        return $this->receiver;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    }

    public function getBic()
    {
        return $this->bic;
    }

    public function setBic($bic)
    {
        $this->bic = $bic;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    public function setReferenceNumber($referenceNumber)
    {
        $this->referenceNumber = $referenceNumber;
    }

    public function getPayerReferenceNumber()
    {
        return $this->payerReferenceNumber;
    }

    public function setPayerReferenceNumber($payerReferenceNumber)
    {
        $this->payerReferenceNumber = $payerReferenceNumber;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getCardNumber()
    {
        return $this->cardNumber;
    }

    public function setCardNumber($cardNumber)
    {
        $this->cardNumber = $cardNumber;
    }

    public function getReceipt()
    {
        return $this->receipt;
    }

    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;
    }
}