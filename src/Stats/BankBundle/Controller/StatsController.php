<?php

namespace Stats\BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\RedirectResponse,
    Stats\BankBundle\Entity\AccountStatement;

class StatsController extends Controller
{
    public function listAction()
    {
        return $this->render('StatsBankBundle:Stats:list.html.twig');
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
}