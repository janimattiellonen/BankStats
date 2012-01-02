<?php

namespace Stats\BankBundle\Twig\Extensions;

use \Twig_Environment;

class Date extends \Twig_Extension
{
    /**
     *
     * @var Twig_Environment
     */
    protected $twig;
    
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function getFunctions()
    {
        return array(
            'stats_date_controller' => new \Twig_Function_Method(
                $this, 'dateController', array('is_safe' => array('html'))
             ),
        );
    }
    
    public function dateController(\DateTime $now)
    {
        $month = date("n", $now->getTimestamp() );
        $year = date('Y', $now->getTimestamp() );
        
        $fd = new \DateTime("$year-$month-01");

        $previousMonth = new \DateTime(date('Y-m-d', strtotime("-1 month", $fd->getTimestamp() ) ) );
        $nextMonth = new \DateTime(date('Y-m-d', strtotime("+1 months", $fd->getTimestamp() ) ) );
        
        return $this->twig->render('StatsBankBundle:Partial:date-controller.html.twig',
                array('now' => $now, 'previous' => $previousMonth, 'next' => $nextMonth)
        );
    }
    
    public function getName()
    {
        return 'date_controller';
    }
}