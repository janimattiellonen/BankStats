<?php

namespace Stats\BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Stats\BankBundle\Entity\AccountStatement,
    Stats\BankBundle\Service\AccountService,
    \Stats\BankBundle\Component\Date\DateRange;

class StatsController extends Controller
{
    public function listAction()
    {
        $service = $this->getAccountService();
        
        $highestDeposit = $service->getHighestDeposit();
        
        $highestWithdrawal = $service->getHighestWithdrawal();
        
        $averageDeposit = $service->getAverageDeposit();
        
        
        return $this->render('StatsBankBundle:Stats:list.html.twig', array(
            'highestDeposit' => $highestDeposit,
            'highestWithdrawal' => $highestWithdrawal,
        ));
    }
    
    public function monthlyAction($month, $year)
    {
        if($month == "now")
        {
            $month = date('m');
        }
        
        if($year == "now")
        {
            $year = date('Y');
        }
        
        $range = new DateRange();
        $start = $range->withFirstDay($month, $year);
        $end = $range->withLastDay($month, $year);
        
        $monthly = $this->getAccountService()->getStatisticsForPeriod($start, $end);
        
        return $this->render('StatsBankBundle:Stats:monthly.html.twig', array(
            'stats' => $monthly,
            'month' => date('F', $start->getTimestamp() ),
            'year' => $year,
        ) );  
    }
    
    public function uploadAction()
    {
        $request = $this->getRequest();
        
        $uploadedFile = $request->files->get('form');
        
        $service = $this->container->get('stats_bank.service.account');
        
        $service->processFile($uploadedFile['attachment']);
        
        return $this->render('StatsBankBundle:Stats:uploaded.html.twig');
    }
    
    public function selectFileAction()
    {
        $service = $this->container->get('stats_bank.service.account');
        
        return $this->render('StatsBankBundle:Stats:select-file.html.twig', array(
            'form' => $service->getAccountStatementForm()->createView()
        ));
    }
    
    /**
     *
     * @return AccountService
     */
    protected function getAccountService()
    {
        return $this->get('stats_bank.service.account');
    }
}