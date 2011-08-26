<?php
namespace Xi\Doctrine\ORM;
use Doctrine\ORM\QueryBuilder as DoctrineQueryBuilder,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Query;

/**
 * Base class for use case specific query builders
 */
class QueryBuilder extends DoctrineQueryBuilder
{
    /**
     * @var array<string => boolean>
     */
    protected $_statuses = array();
    
    /**
     * @var array<callback(Query)>
     */
    protected $_queryConfigurers = array();
    
    /**
     * Create a new QueryBuilder of the type that receives this static call.
     *
     * @param EntityManager $em
     * @return QueryBuilder
     */
    public static function create(EntityManager $em)
    {
        return new static($em);
    }
    
    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->init();
    }
    
    /**
     * Post-construction template method
     */
    public function init() {}
    
    /**
     * Configures the created Query using the configurers added to this builder
     * 
     * @return \Doctrine\ORM\Query
     */
    public function getQuery()
    {
        $query = parent::getQuery();
        foreach ($this->_queryConfigurers as $configurer) {
            $configurer($query);
        }
        return $query;
    }
    
    /**
     * NOTE: Should be protected
     * 
     * @param callback(Doctrine\ORM\Query) $configurer
     * @return QueryBuilder 
     */
    public function _configureQuery($configurer)
    {
        $this->_queryConfigurers[] = $configurer;
        return $this;
    }
    
    /**
     * Ensure that a certain operation has been performed on this object.
     * $status is a string that describes state the operation should affect and
     * $operation is a callback which is executed if and only if the status is
     * not already in effect.
     * 
     * Example:
     * 
     * public function withProduct() {
     *     return $this->_ensure('product is joined', function($qb) {
     *         $qb->join('pv.product', 'p');
     *     });
     * }
     * 
     * Should be used to allow the possibility of several different methods
     * each wanting to affect a certain state without messing up the query by
     * duplicate calls to methods. Has the pleasant side effect of describing
     * the results of operations on a more intimate level than the plain object
     * API can allow for, making for more self-documenting code.
     * 
     * @param string $status
     * @param callback(QueryBuilder) $operation
     * @return QueryBuilder
     */
    protected function _ensure($status, $operation)
    {
        if (empty($this->_statuses[$status])) {
            $operation($this);
            $this->_statuses[$status] = true;
        }
        return $this;
    }
    
    /**
     * Configures the query to force result objects to be partially loaded
     * 
     * @return QueryBuilder
     */
    protected function _asPartial()
    {
        return $this->_ensure('partial loading is forced', function(QueryBuilder $builder) {
            $builder->_configureQuery(function(Query $query) {
                $query->setHint(Query::HINT_FORCE_PARTIAL_LOAD, true);
            });
        });
    }
}