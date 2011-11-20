<?php
namespace Stats\BankBundle\Component\Validator;

use Symfony\Component\Validator\Validator;

class AccountValidator
{
    /**
     * @var Validator
     */
    private $validator;

    /**
     * @param Validator $validator 
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }
    
    public function validate($accountStatement)
    {
        return $this->validator->validate($accountStatement);
    }
}