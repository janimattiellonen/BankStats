<?php
namespace Stats\BankBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AttachmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attachment', 'file');
    }
    
    public function getName()
    {
        return 'stats_bankbundle_attachmenttype';
    }
}