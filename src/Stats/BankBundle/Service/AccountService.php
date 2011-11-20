<?php
namespace Stats\BankBundle\Service;

use Doctrine\ORM\EntityManager,
    Symfony\Component\Form\FormFactory,
    Symfony\Component\Form\Form,
    Stats\BankBundle\Entity\AccountStatement,
    Stats\BankBundle\Form\AccountStatementType,
    Symfony\Component\HttpFoundation\File\File,
    Symfony\Component\HttpFoundation\File\UploadedFile,
    Stats\Component\Csv\Parser,
    Symfony\Component\Validator\Validator,
    Stats\BankBundle\Component\Validator\AccountValidator,
    \Stats\BankBundle\Repository\AccountStatementRepository;
    

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
     * @var AccountValidator
     */
    private $validator;
    
    /**
     * @var AccountStatementRepository
     */
    private $repository;
    
    /**
     * @param EntityManager $em
     * @param FormFactory $factory 
     * @param Uploader $uploader
     * @param Parser $parser
     * @param AccountValidator $validator
     */
    public function __construct(EntityManager $em, FormFactory $factory, 
                                Uploader $uploader, Parser $parser,
                                AccountValidator $validator,
                                AccountStatementRepository $repository)
    {
        $this->em = $em;
        $this->formFactory = $factory;
        $this->uploader = $uploader;
        $this->parser = $parser;
        $this->validator = $validator;
        $this->repository = $repository;
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
        $data = $this->parser->parse(file_get_contents($file->getPathname() ) );
        
        if(null == $data || !isset($data['content']) )
        {
            throw new Exception('Incorrect data provided');
        }
        
        $arr = $data['content'];
        
        $this->em->beginTransaction();
        
        foreach($arr as $content)
        {    
            if(!$this->rowExists($content) )
            {
                $as = new AccountStatement();
                $as->setEntryDate(new \DateTime($content[0]) )
                   ->setValueDate(new \DateTime($content[1]) )
                   ->setPaymentDate(new \DateTime($content[2]) )
                   ->setAmount($content[3])
                   ->setReceiver($content[4])
                   ->setAccountNumber($content[5])
                   ->setBic($content[6])
                   ->setEvent($content[7])
                   ->setReferenceNumber($content[8])
                   ->setPayerReferenceNumber($content[9])
                   ->setMessage($content[10])
                   ->setCardNumber($content[11])
                   ->setReceipt($content[12]);

                $result = $this->validator->validate($as);

                if(count($result) > 0)
                {
                    $this->em->rollback();
                    throw new Exception('One or more of the rows in the file contained incorrect data.');
                }

                $this->em->persist($as);
            }
        }
        
        $this->em->flush();
        $this->em->commit();
    }
    
    /**
     *
     * @param array $data
     * 
     * @return boolean 
     */
    protected function rowExists(array $data)
    {
        return $this->repository->rowExists(
                new \DateTime($data[0]),
                new \DateTime($data[1]),
                new \DateTime($data[2]),
                $data[3],
                $data[4]
        );
    }
    
}