<?php

namespace App\Twig\Components;

use App\Stub\AdminPatientStub;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsLiveComponent]
class AdminPatientList
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $filterFirstName = '';

    #[LiveProp(writable: true)]
    public string $filterLastName = '';

    #[LiveProp(writable: true)]
    public string $filterEmail = '';

    #[LiveProp(writable: true)]
    public string $filterPhone = '';

    #[LiveAction]
    public function clearFilters(): void
    {
        $this->filterFirstName = '';
        $this->filterLastName  = '';
        $this->filterEmail     = '';
        $this->filterPhone     = '';
    }

    #[ExposeInTemplate]
    public function getFilteredPatients(): array
    {
        $patients = AdminPatientStub::allPatients();

        if ('' !== $this->filterFirstName) {
            $q = mb_strtolower($this->filterFirstName);
            // Match against the first word of patientName
            $patients = array_filter($patients, function ($p) use ($q) {
                $parts = explode(' ', mb_strtolower($p['patientName']), 2);
                return str_contains($parts[0], $q);
            });
        }

        if ('' !== $this->filterLastName) {
            $q = mb_strtolower($this->filterLastName);
            // Match against everything after the first word
            $patients = array_filter($patients, function ($p) use ($q) {
                $parts = explode(' ', mb_strtolower($p['patientName']), 2);
                return isset($parts[1]) && str_contains($parts[1], $q);
            });
        }

        if ('' !== $this->filterEmail) {
            $q = mb_strtolower($this->filterEmail);
            $patients = array_filter($patients, fn($p) => str_contains(mb_strtolower($p['patientEmail']), $q));
        }

        if ('' !== $this->filterPhone) {
            // Strip spaces for comparison so "07700900123" matches "07700 900 123"
            $q = preg_replace('/\s+/', '', $this->filterPhone);
            $patients = array_filter($patients, function ($p) use ($q) {
                return str_contains(preg_replace('/\s+/', '', $p['patientPhone']), $q);
            });
        }

        return array_values($patients);
    }

    #[ExposeInTemplate]
    public function hasActiveFilters(): bool
    {
        return '' !== $this->filterFirstName
            || '' !== $this->filterLastName
            || '' !== $this->filterEmail
            || '' !== $this->filterPhone;
    }
}
