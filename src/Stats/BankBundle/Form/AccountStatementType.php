<?php
namespace Stats\BankBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountStatementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('entryDate', 'date', array(
                'label' => 'Entry date',
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'datepicker') ) )
            ->add('valueDate', 'date', array(
                'label' => 'Value date',
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'datepicker') ) )
            ->add('paymentDate', 'date', array(
                'label' => 'Payment date',
                'widget' => 'single_text',
                'format' => 'dd.MM.yyyy',
                'attr' => array('class' => 'datepicker') ) )
            ->add('amount', 'number')    
            ->add('receiver', 'text', array(
                'label' => 'From/To'
                ))    
            ->add('accountNumber', 'text', array(
                'label' => 'Account number',
            ))
            ->add('bic') 
            ->add('event')    
            ->add('referenceNumber', 'text', array(
                'label' => 'Reference number',
            ))
            ->add('payerReferenceNumber', 'text', array(
                'label' => 'Payer reference number',
            ))
            ->add('message', 'textarea') 
            ->add('cardNumber', 'text', array(
                'label' => 'Card number',
            ))
            ->add('receipt')     
            ;
    }
    
    public function getName()
    {
        return 'stats_bankbundle_accountstatementtype';
    }
}