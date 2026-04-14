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
    public string $filterQuery = '';

    #[LiveAction]
    public function clearFilters(): void
    {
        $this->filterQuery = '';
    }

    #[ExposeInTemplate]
    public function getFilteredPatients(): array
    {
        $patients = AdminPatientStub::allPatients();

        $q = trim($this->filterQuery);
        if ($q === '') {
            return array_values($patients);
        }

        $q = mb_strtolower($q);
        $qStripped = preg_replace('/\s+/', '', $q);

        return array_values(array_filter($patients, function ($p) use ($q, $qStripped) {
            if (str_contains(mb_strtolower($p['patientName']), $q)) {
                return true;
            }
            if (str_contains(mb_strtolower($p['patientEmail']), $q)) {
                return true;
            }
            $phoneStripped = preg_replace('/\s+/', '', $p['patientPhone']);
            if (str_contains($phoneStripped, $qStripped)) {
                return true;
            }
            if (str_contains(mb_strtolower($p['customerId']), $q)) {
                return true;
            }

            return false;
        }));
    }

    #[ExposeInTemplate]
    public function hasActiveFilters(): bool
    {
        return $this->filterQuery !== '';
    }
}
