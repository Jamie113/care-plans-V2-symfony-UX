<?php

namespace App\Controller;

use App\Stub\AdminPatientStub;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    /**
     * Patient list — the primary entry point for admin users.
     * Shows one row per patient with their current plan status.
     */
    #[Route('/patients', name: 'admin_patient_list')]
    public function patientList(): Response
    {
        return $this->render('admin/patient_list.html.twig');
    }

    /**
     * Patient detail — overview of a patient and all their plans.
     */
    #[Route('/patients/{customerId}', name: 'admin_patient_detail')]
    public function patientDetail(string $customerId): Response
    {
        $patient = AdminPatientStub::findByCustomerId($customerId);

        if (!$patient) {
            throw $this->createNotFoundException('Patient not found.');
        }

        return $this->render('admin/patient_detail.html.twig', [
            'patient' => $patient,
        ]);
    }

    /**
     * Plan detail — full detail and actions for a single care plan.
     * Accessible from the patient detail page.
     */
    #[Route('/plans/{id}', name: 'admin_plan_detail', requirements: ['id' => '\d+'])]
    public function planDetail(int $id): Response
    {
        $plan = AdminPatientStub::findById($id);

        if (!$plan) {
            throw $this->createNotFoundException('Plan not found.');
        }

        return $this->render('admin/plan_detail.html.twig', [
            'plan' => $plan,
        ]);
    }

    /**
     * Legacy redirect — /admin/plans bounces to the new patient list.
     */
    #[Route('/plans', name: 'admin_plan_list')]
    public function planListRedirect(): Response
    {
        return $this->redirectToRoute('admin_patient_list');
    }
}
