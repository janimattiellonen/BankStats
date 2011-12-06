<?php

namespace Stats\BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Stats\BankBundle\Entity\AccountStatement,
    Stats\BankBundle\Service\AccountService,
    Stats\BankBundle\Component\Date\DateRange;

class StatsController extends Controller
{
    public function newAction()
    {
        $service = $this->getAccountService();
        
        return $this->render('StatsBankBundle:stats:edit.html.twig', array(
            'form' => $service->getAccountStatementForm(new AccountStatement)->createView()
        ));
    }
    
    public function saveAction()
    {
        $service = $this->getAccountService();
        $form = $service->getAccountStatementForm(new AccountStatement() );
        
        if($form->bindRequest($this->getRequest() )->isValid() )
        {
            $service->saveAcctountStatementByForm($form);
            return $this->redirect($this->generateUrl('stats_stats_list') );
        }
        else
        {
            return $this->render('StatsBankBundle:stats:edit.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }
    
    public function listAction()
    {
        $service = $this->getAccountService();
        
        $highestDeposit = $service->getHighestDeposit();
        
        $highestWithdrawal = $service->getHighestWithdrawal();
        
        $averageDeposit = $service->getAverageDeposit();
        
        
        return $this->render('StatsBankBundle:stats:list.html.twig', array(
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
        
        if(!isset($monthly) )
        {
            return $this->render('StatsBankBundle:stats:no-stats.html.twig', array(
                'date' => $range->withFirstDay(date('m'), date('Y') )
            ));
        }
        
        return $this->render('StatsBankBundle:stats:monthly.html.twig', array(
            'stats' => $monthly,
            'month' => date('F', $start->getTimestamp() ),
            'year' => $year,
            'date' => $start, 
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
        $service = $this->getAccountService();
        
        return $this->render('StatsBankBundle:stats:select-file.html.twig', array(
            'form' => $service->getAttachmentForm()->createView()
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