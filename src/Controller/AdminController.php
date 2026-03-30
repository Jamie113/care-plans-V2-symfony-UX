<?php

namespace App\Controller;

use App\Stub\AdminPatientStub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/plans', name: 'admin_plan_list')]
    public function list(): Response
    {
        return $this->render('admin/plan_list.html.twig', [
            'stats' => AdminPatientStub::stats(),
        ]);
    }

    #[Route('/plans/{id}', name: 'admin_plan_detail', requirements: ['id' => '\d+'])]
    public function detail(int $id): Response
    {
        $plan = AdminPatientStub::findById($id);

        if (!$plan) {
            throw $this->createNotFoundException('Plan not found.');
        }

        $upcomingEvents = [];

        if ($plan['nextOrderDate']) {
            $upcomingEvents[] = ['label' => 'Next order dispatch', 'date' => $plan['nextOrderDate']];
        }

        if ($plan['nextBillingDate']) {
            $upcomingEvents[] = ['label' => 'Next billing', 'date' => $plan['nextBillingDate']];
        }

        if ($plan['startDate'] && $plan['ordersTotal'] > 0) {
            // Estimate plan end date: startDate + (ordersTotal × cycleDays)
            $endDate = (new \DateTimeImmutable($plan['startDate']))
                ->modify(sprintf('+%d days', $plan['ordersTotal'] * $plan['cycleDays']))
                ->format('Y-m-d');
            $upcomingEvents[] = ['label' => 'Plan end date', 'date' => $endDate];
        }

        usort($upcomingEvents, fn($a, $b) => strcmp($a['date'], $b['date']));

        return $this->render('admin/plan_detail.html.twig', [
            'plan'           => $plan,
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
