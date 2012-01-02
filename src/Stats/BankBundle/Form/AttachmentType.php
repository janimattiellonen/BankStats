<?php
namespace Stats\BankBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilder;

class AttachmentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('attachment', 'file');
    }
    
    public function getName()
    {
        return 'stats_bankbundle_attachmenttype';
    }
}