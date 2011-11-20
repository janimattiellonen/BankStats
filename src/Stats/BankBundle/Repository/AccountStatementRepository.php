<?php
namespace Stats\BankBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException,
    Doctrine\ORM\Doctrine\ORM\QueryBuilder,
    Stats\BankBundle\Entity\AccountStatement;


class AccountStatementRepository extends EntityRepository
{
    /**
     * @param \DateTime $entryDate
     * @param \DateTime $valueDate
     * @param \DateTime $paymentDate
     * @param type $amount
     * @param type $receiver
     * 
     * @return boolean
     */
    public function rowExists(\DateTime $entryDate, 
                              \DateTime $valueDate, 
                              \DateTime $paymentDate, 
                              $amount, 
                              $receiver)
    {
        $qb = $this->getBaseQueryBuilder()
                   ->where('account.entryDate = :entryDate')
                   ->andWhere('account.valueDate = :valueDate')
                   ->andWhere('account.paymentDate = :paymentDate')
                   ->andWhere('account.amount = :amount')
                   ->andWhere('account.receiver = :receiver')
                   ->setParameters(array(
                       'entryDate' => $entryDate,
                       'valueDate' => $valueDate,
                       'paymentDate' => $paymentDate,
                       'amount' => $amount,
                       'receiver' => $receiver
                   ));
        
        try
        {
            $qb->getQuery()->getSingleResult();
            
            return true;
        }
        catch(NoResultException $e)
        {
            return false;
        }
    }
    
    /**
     * @return AccountStatement or null 
     */
    public function getHighestWithdrawal()
    {
        $qb = $this->getBaseQueryBuilder()
                   ->where('account.amount < 0')
                   ->orderBy('account.amount', 'DESC');
        
        return $this->getSingleResult($qb);
    }
    
    /**
     * @return AccountStatement or null
     */
    public function getHighestDeposit()
    {
        $qb = $this->getBaseQueryBuilder()
                   ->where('account.amount > 0')
                   ->orderBy('account.amount', 'ASC');
        
        return $this->getSingleResult($qb);
    }
    
    /**
     * @param QueryBuilder $qb
     * @return found Entity or null
     */
    protected function getSingleResult(QueryBuilder $qb)
    {
        try
        {
            return $qb->getQuery()->getSingleResult();
        }
        catch(NoResultException $e)
        {
            return null;
        }
    }
    
    /**
     * @return QueryBuilder
     */
    protected function getBaseQueryBuilder()
    {
        return $this->getEntityManager()->createQueryBuilder()
                   ->select('account')
                   ->from('Stats\BankBundle\Entity\AccountStatement', 'account');
    }
}