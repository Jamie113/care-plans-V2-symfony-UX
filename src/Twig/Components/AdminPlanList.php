<?php

namespace App\Twig\Components;

use App\Stub\AdminPatientStub;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\ExposeInTemplate;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class AdminPlanList
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $search = '';

    #[LiveProp(writable: true)]
    public string $statusFilter = '';

    #[ExposeInTemplate]
    public function getFilteredPlans(): array
    {
        $plans = AdminPatientStub::all();

        if ('' !== $this->search) {
            $q = mb_strtolower($this->search);
            $plans = array_filter($plans, function ($p) use ($q) {
                return str_contains(mb_strtolower($p['patientName']), $q)
                    || str_contains(mb_strtolower($p['patientEmail']), $q);
            });
        }

        if ('' !== $this->statusFilter) {
            $plans = array_filter($plans, fn($p) => $p['status'] === $this->statusFilter);
        }

        return array_values($plans);
    }
}
