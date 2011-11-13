<?php

namespace BankStats\BankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StatsController extends Controller
{
    public function listAction()
    {
        return $this->render('BankStatsBankBundle:Stats:list.html.twig');
    }
}