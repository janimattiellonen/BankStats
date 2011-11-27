<?php
namespace Stats\BankBundle\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\NoResultException,
    Doctrine\ORM\QueryBuilder,
    Stats\BankBundle\Entity\AccountStatement,
    Jme\DoctrineExtensions\Query\Mysql\Month,
    Doctrine\ORM\Query\ResultSetMapping;


class AccountStatementRepository extends EntityRepository
{
    const DEPOSIT = 1;
    const WITHDRAWAL = 2;
    
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
        $results = $this->getHighestWithdrawals(1);
        
        return isset($results) && count($results) > 0 ? $results[0] : null;
    }
    
    /**
     * @return array
     */
    public function getHighestWithdrawals($limit, \DateTime $start = null, \DateTime $end = null)
    {
        $qb = $this->getBaseQueryBuilder()
                   ->andWhere('account.amount < 0')
                   ->orderBy('account.amount', 'ASC')
                   ->setMaxResults($limit);
        
        $this->createDateRange($qb, 'account.entryDate', $start, $end);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     *
     * @param QueryBuilder $qb
     * @param type $fieldName
     * @param \DateTime $start
     * @param \DateTime $end
     * @param type $exact if no end date is given and $exact is true then $date = is used instead of $date >=
     */
    protected function createDateRange(QueryBuilder $qb, $fieldName, \DateTime $start = null, \DateTime $end = null, $exact = true)
    {
        if(isset($start) && isset($end) )
        {
            $qb->andWhere("$fieldName BETWEEN :start AND :end")
               ->setParameters(array(
                   'start' => $start,
                   'end' => $end,
               ));
        }
        else if(isset($start) && !isset($end) )
        {
            $op = $exact ? '=' : '>=';
            
            $qb->andWhere("$fieldName $op :date")
               ->setParameter('date', $start);
        }
        else if(isset($end) )
        {
            $qb->andWhere("$fieldName <= :end")
               ->setParameter('end', $end);
        }
    }

    /**
     * @return AccountStatement or null
     */
    public function getHighestDeposit()
    {
        $results = $this->getHighestDeposits(1);
        
        return isset($results) && count($results) > 0 ? $results[0] : null;
    }    
    
    /**
     * @return array
     */
    public function getHighestDeposits($limit, \DateTime $start = null, \DateTime $end = null)
    {
        $qb = $this->getBaseQueryBuilder()
                   ->where('account.amount > 0')
                   ->orderBy('account.amount', 'DESC')
                   ->setMaxResults($limit);
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     *
     * @param \DateTime $date 
     * 
     * @return array array of AccountStatement objects
     */
    public function getSpendingForSpecificDate(\DateTime $date)
    {
        return $this->getWithdrawalsFor($date, $date);
    }
    
    /**
     * @param \DateTime $start
     * @param \DateTime $end 
     * 
     * @return array
     */
    public function getDailySpendingForPeriod(\DateTime $start, \DateTime $end)
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql = 'SELECT
                SUM(ABS(account.amount) ) AS amount,
                DAY(account.entry_date) AS day,
                count(account.entry_date) AS transaction_count
            FROM
                accountstatement AS account
            WHERE
                account.amount < 0
                AND account.entry_date between :start AND :end
            GROUP BY
                account.entry_date';
        
        
        $startDate = $start->format('Y-m-d');
        $endDate = $end->format('Y-m-d');
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('start', $startDate);
        $stmt->bindValue('end', $endDate);
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * @param int $month
     * @param int $year
     * @return array|null
     */
    public function getStatisticsForPeriod(\DateTime $start, \DateTime $end)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('Stats\BankBundle\Entity\AccountStatement', 'account');
        $rsm->addFieldResult('account', 'id', 'id');
        $rsm->addFieldResult('account', 'entry_date', 'entryDate');
        $rsm->addFieldResult('account', 'value_date', 'valueDate');
        $rsm->addFieldResult('account', 'payment_date', 'paymentDate');
        $rsm->addFieldResult('account', 'amount', 'amount');
        $rsm->addFieldResult('account', 'receiver', 'receiver');
        $rsm->addFieldResult('account', 'account_number', 'accountNumber');
        $rsm->addFieldResult('account', 'bic', 'bic');
        $rsm->addFieldResult('account', 'event', 'event');
        $rsm->addFieldResult('account', 'reference_number', 'referenceNumber');
        $rsm->addFieldResult('account', 'payment_reference_number', 'payerReferenceNumber');
        $rsm->addFieldResult('account', 'message', 'message');
        $rsm->addFieldResult('account', 'card_number', 'cardNumber');
        $rsm->addFieldResult('account', 'receipt', 'receipt');
        
        $rsm->addScalarResult('month1', 'month');
        $rsm->addScalarResult('year1', 'year');
        $rsm->addScalarResult('sum', 'sum');
        $rsm->addScalarResult('withdrawals', 'withdrawals');
        $rsm->addScalarResult('deposits', 'deposits');
        
        $sql = "SELECT
                        id,
                        entry_date,
                        value_date,
                        payment_date,
                        amount,
                        receiver,
                        account_number,
                        bic,
                        event,
                        reference_number,
                        payment_reference_number,
                        message,
                        card_number,
                        receipt,
                        MONTH(entry_date) AS month1,
                        YEAR(entry_date) AS year1,
                        (SELECT SUM(amount) FROM accountstatement WHERE amount < 0 AND YEAR(entry_date) = year1 AND month(entry_date) = month1) AS 'withdrawals',
                        (SELECT SUM(amount) FROM accountstatement WHERE amount > 0 AND YEAR(entry_date) = year1 AND month(entry_date) = month1) AS 'deposits',
                        SUM(amount) AS sum
                    FROM 
                        accountstatement
                    WHERE
                        entry_date >= ? AND entry_date <= ?
                    GROUP BY
                        YEAR(entry_date),
                        MONTH(entry_date)";
        
        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        
        $query->setParameter(1, $start->format('Y-m-d') );
        $query->setParameter(2, $end->format('Y-m-d') );
        
        $results = $query->getResult();
        
        return isset($results) && count($results) > 0 ? $results[0] : null;
    }
    
    public function getDepositsFor(\DateTime $start, \DateTime $end)
    {
        return $this->getEventsFor($start, $end, self::DEPOSIT);
    }
    
    public function getWithdrawalsFor(\DateTime $start, \DateTime $end)
    {
        return $this->getEventsFor($start, $end, self::WITHDRAWAL);
    }
    
    public function getEventsFor(\DateTime $start, \DateTime $end, $type)
    {
        $qb = $this->getBaseQueryBuilder();
        
        $expr = $type == self::DEPOSIT ? '> 0' : '< 0';
        $qb->where("account.amount $expr");
        
        $qb = $this->createDateRangeQuery($qb, $start, $end);
        
        
    }
    
    /**
     *
     * @param QueryBuilder $qb
     * @param \DateTime $start
     * @param \DateTime $end
     * @return QueryBuilder 
     */
    protected function createDateRangeQuery(QueryBuilder $qb, \DateTime $start, \DateTime $end)
    {
        return $qb->addWhere('account.entryDate BETWEEN :start AND :end')
           ->setParameters(array(
               'start' => $start,
               'end' => $end,
        ));
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