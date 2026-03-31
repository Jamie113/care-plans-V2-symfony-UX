<?php

namespace App\Twig\Components;

use App\Stub\AdminPatientStub;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
class AdminPlanList
{
    use DefaultActionTrait;

    // Specific filters — applied first, each narrows the result set
    #[LiveProp(writable: true)]
    public string $filterPlanId = '';

    #[LiveProp(writable: true)]
    public string $filterCustomerId = '';

    #[LiveProp(writable: true)]
    public string $statusFilter = '';

    #[LiveProp(writable: true)]
    public string $filterPlanName = '';

    #[LiveProp(writable: true)]
    public string $filterDateFrom = '';

    #[LiveProp(writable: true)]
    public string $filterDateTo = '';

    // Fuzzy search — fallback for name / email, applied last
    #[LiveProp(writable: true)]
    public string $search = '';

    #[LiveAction]
    public function clearFilters(): void
    {
        $this->filterPlanId     = '';
        $this->filterCustomerId = '';
        $this->statusFilter     = '';
        $this->filterPlanName   = '';
        $this->filterDateFrom   = '';
        $this->filterDateTo     = '';
        $this->search           = '';
    }

    #[ExposeInTemplate]
    public function getFilteredPlans(): array
    {
        $plans = AdminPatientStub::all();

        if ('' !== $this->filterPlanId) {
            $q = mb_strtolower($this->filterPlanId);
            $plans = array_filter($plans, fn($p) => str_contains(mb_strtolower($p['planId']), $q));
        }

        if ('' !== $this->filterCustomerId) {
            $q = mb_strtolower($this->filterCustomerId);
            $plans = array_filter($plans, fn($p) => str_contains(mb_strtolower($p['customerId']), $q));
        }

        if ('' !== $this->statusFilter) {
            $plans = array_filter($plans, fn($p) => $p['status'] === $this->statusFilter);
        }

        if ('' !== $this->filterPlanName) {
            $q = mb_strtolower($this->filterPlanName);
            $plans = array_filter($plans, fn($p) => str_contains(mb_strtolower($p['planName']), $q));
        }

        if ('' !== $this->filterDateFrom) {
            $plans = array_filter($plans, fn($p) => null !== $p['nextOrderDate'] && $p['nextOrderDate'] >= $this->filterDateFrom);
        }

        if ('' !== $this->filterDateTo) {
            $plans = array_filter($plans, fn($p) => null !== $p['nextOrderDate'] && $p['nextOrderDate'] <= $this->filterDateTo);
        }

        if ('' !== $this->search) {
            $q = mb_strtolower($this->search);
            $plans = array_filter($plans, fn($p) =>
                str_contains(mb_strtolower($p['patientName']), $q)
                || str_contains(mb_strtolower($p['patientEmail']), $q)
            );
        }

        return array_values($plans);
    }

    #[ExposeInTemplate]
    public function hasActiveFilters(): bool
    {
        return '' !== $this->filterPlanId
            || '' !== $this->filterCustomerId
            || '' !== $this->statusFilter
            || '' !== $this->filterPlanName
            || '' !== $this->filterDateFrom
            || '' !== $this->filterDateTo
            || '' !== $this->search;
    }
}
