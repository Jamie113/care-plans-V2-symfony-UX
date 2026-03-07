<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanController extends AbstractController
{
    #[Route('/plan/new', name: 'plan_new')]
    public function new(): Response
    {
        return $this->render('plan/new.html.twig');
    }
}
