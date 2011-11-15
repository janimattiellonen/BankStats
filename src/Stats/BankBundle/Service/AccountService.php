<?php
namespace Stats\BankBundle\Service;

use Doctrine\ORM\EntityManager,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Form\Form,
    Stats\BankBundle\Entity\AccountStatement,
    Stats\BankBundle\Form\AccountStatementType,
    Symfony\Component\HttpFoundation\File\File,
    Symfony\Component\HttpFoundation\File\UploadedFile,
    Stats\Component\Csv\Parser;
    

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
    private $formFactory;
    
    
    /**
     *
     * @var File
     */
    private $uploadedFile;
    
    /**
     * @var Uploader 
     */
    private $uploader;
    
    /**
     *
     * @var Parser
     */
    private $parser;
    
    /**
     * @param EntityManager $em
     * @param FormFactory $factory 
     * @param Uploader $uploader
     * @param Parser $parser
     */
    public function __construct(EntityManager $em, FormFactory $factory, 
                                Uploader $uploader, Parser $parser)
    {
        $this->em = $em;
        $this->formFactory = $factory;
        $this->uploader = $uploader;
        $this->parser = $parser;
    }
    
    /**
     *
     * @return Form
     */
    public function getAccountStatementForm()
    {
        return $this->formFactory->createBuilder('form')
                ->add('attachment', 'file')
                ->getForm();
    }
    
    /**
     * @param UploadedFile $file
     */
    public function processFile(UploadedFile $file)
    {
        $this->uploader->upload($file);
        
        $uploadedFile = $this->uploader->getUploadedFile();
        
        $this->save($uploadedFile);
    }
    
    /**
     * @param File $file 
     */
    public function save(File $file)
    {
        echo file_get_contents($file->getPathname() );die;
    }
}