<?php

namespace App\Twig\Components;

use App\Catalogue\Catalogues;
use Symfony\Component\Uid\Uuid;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

/**
 * Central Live Component for the treatment plan builder.
 * Holds all reactive state — equivalent to usePlanState() in the React prototype.
 */
#[AsLiveComponent]
class TreatmentPlanBuilder
{
    use DefaultActionTrait;

    // ── Plan basics ───────────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public string $planName = '';

    #[LiveProp(writable: true)]
    public string $durationId = '6m';

    #[LiveProp(writable: true)]
    public int $customDurationMonths = 6;

    #[LiveProp(writable: true)]
    public bool $autoRenew = false;

    #[LiveProp(writable: true)]
    public string $startBehaviour = 'immediately';

    #[LiveProp(writable: true)]
    public string $startDate = '';

    // ── Medications ───────────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public array $medications = [];

    // ── Dispatch ──────────────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public string $cycleId = '4w';

    #[LiveProp(writable: true)]
    public int $customCycleDays = 28;

    #[LiveProp(writable: true)]
    public bool $allowPatientRescheduling = true;

    #[LiveProp(writable: true)]
    public int $rescheduleDaysEarlier = 5;

    #[LiveProp(writable: true)]
    public int $rescheduleDaysLater = 10;

    // ── Inclusions ────────────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public array $inclusions = [];

    // ── Offers ────────────────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public array $offers = [];

    // ── Upsells ───────────────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public array $upsells = [];

    // ── Plan output modal ─────────────────────────────────────────────────────

    #[LiveProp(writable: true)]
    public bool $showPlanModal = false;

    // ──────────────────────────────────────────────────────────────────────────

    public function mount(): void
    {
        if (!$this->startDate) {
            $this->startDate = (new \DateTimeImmutable('+2 days'))->format('Y-m-d');
        }
        if (empty($this->medications)) {
            $this->medications = [$this->newMedicationItem()];
        }
    }

    // ── Medication actions ────────────────────────────────────────────────────

    #[LiveAction]
    public function addMedication(): void
    {
        $this->medications[] = $this->newMedicationItem();
    }

    #[LiveAction]
    public function removeMedication(#[LiveArg] string $key): void
    {
        $this->medications = array_values(
            array_filter($this->medications, fn ($m) => $m['key'] !== $key)
        );
    }

    #[LiveAction]
    public function setMedicationVariant(#[LiveArg] string $key, #[LiveArg] string $variantId): void
    {
        $this->medications = array_map(
            fn ($m) => $m['key'] === $key ? array_merge($m, ['variantId' => $variantId]) : $m,
            $this->medications
        );
    }

    #[LiveAction]
    public function setMedicationProduct(#[LiveArg] string $key, #[LiveArg] string $medicationId): void
    {
        $this->medications = array_map(function ($m) use ($key, $medicationId) {
            if ($m['key'] !== $key) {
                return $m;
            }

            return array_merge($m, [
                'medicationId'     => $medicationId,
                'variantId'        => '',
                'titrationPathId'  => '',
                'titrationEnabled' => false,
            ]);
        }, $this->medications);
    }

    // ── Inclusion actions ─────────────────────────────────────────────────────

    #[LiveAction]
    public function addInclusion(): void
    {
        $this->inclusions[] = $this->newInclusionItem();
    }

    #[LiveAction]
    public function removeInclusion(#[LiveArg] string $key): void
    {
        $this->inclusions = array_values(
            array_filter($this->inclusions, fn ($i) => $i['key'] !== $key)
        );
    }

    #[LiveAction]
    public function setInclusionProduct(#[LiveArg] string $key, #[LiveArg] string $productId): void
    {
        $this->inclusions = array_map(function ($i) use ($key, $productId) {
            if ($i['key'] !== $key) {
                return $i;
            }

            return array_merge($i, ['productId' => $productId, 'variantId' => '']);
        }, $this->inclusions);
    }

    #[LiveAction]
    public function setInclusionScheduleType(#[LiveArg] string $key, #[LiveArg] string $type): void
    {
        $this->inclusions = array_map(
            fn ($i) => $i['key'] === $key ? array_merge($i, ['scheduleType' => $type]) : $i,
            $this->inclusions
        );
    }

    #[LiveAction]
    public function toggleInclusionOrder(#[LiveArg] string $key, #[LiveArg] int $orderNum): void
    {
        $this->inclusions = array_map(function ($i) use ($key, $orderNum) {
            if ($i['key'] !== $key) {
                return $i;
            }
            $nums = $i['orderNumbers'];
            if (in_array($orderNum, $nums, true)) {
                $nums = array_values(array_filter($nums, fn ($n) => $n !== $orderNum));
            } else {
                $nums[] = $orderNum;
                sort($nums);
            }

            return array_merge($i, ['orderNumbers' => $nums]);
        }, $this->inclusions);
    }

    // ── Offer actions ─────────────────────────────────────────────────────────

    #[LiveAction]
    public function addOffer(): void
    {
        $this->offers[] = $this->newOfferItem();
    }

    #[LiveAction]
    public function removeOffer(#[LiveArg] string $key): void
    {
        $this->offers = array_values(
            array_filter($this->offers, fn ($o) => $o['key'] !== $key)
        );
    }

    #[LiveAction]
    public function setOfferType(#[LiveArg] string $key, #[LiveArg] string $type): void
    {
        $this->offers = array_map(
            fn ($o) => $o['key'] === $key ? array_merge($o, ['offerType' => $type]) : $o,
            $this->offers
        );
    }

    // ── Upsell actions ────────────────────────────────────────────────────────

    #[LiveAction]
    public function addUpsell(): void
    {
        $this->upsells[] = $this->newUpsellItem();
    }

    #[LiveAction]
    public function removeUpsell(#[LiveArg] string $key): void
    {
        $this->upsells = array_values(
            array_filter($this->upsells, fn ($u) => $u['key'] !== $key)
        );
    }

    #[LiveAction]
    public function setUpsellProduct(#[LiveArg] string $key, #[LiveArg] string $productId): void
    {
        $this->upsells = array_map(function ($u) use ($key, $productId) {
            if ($u['key'] !== $key) {
                return $u;
            }

            return array_merge($u, ['productId' => $productId, 'variantId' => '']);
        }, $this->upsells);
    }

    #[LiveAction]
    public function setUpsellScheduleType(#[LiveArg] string $key, #[LiveArg] string $type): void
    {
        $this->upsells = array_map(
            fn ($u) => $u['key'] === $key ? array_merge($u, ['scheduleType' => $type]) : $u,
            $this->upsells
        );
    }

    #[LiveAction]
    public function setUpsellPricingType(#[LiveArg] string $key, #[LiveArg] string $type): void
    {
        $this->upsells = array_map(
            fn ($u) => $u['key'] === $key ? array_merge($u, ['pricingType' => $type]) : $u,
            $this->upsells
        );
    }

    #[LiveAction]
    public function toggleUpsellOrder(#[LiveArg] string $key, #[LiveArg] int $orderNum): void
    {
        $this->upsells = array_map(function ($u) use ($key, $orderNum) {
            if ($u['key'] !== $key) {
                return $u;
            }
            $nums = $u['orderNumbers'];
            if (in_array($orderNum, $nums, true)) {
                $nums = array_values(array_filter($nums, fn ($n) => $n !== $orderNum));
            } else {
                $nums[] = $orderNum;
                sort($nums);
            }

            return array_merge($u, ['orderNumbers' => $nums]);
        }, $this->upsells);
    }

    // ── Computed values ───────────────────────────────────────────────────────

    #[ExposeInTemplate]
    public function getDuration(): int
    {
        if ($this->durationId === 'custom') {
            return max(1, $this->customDurationMonths);
        }
        foreach (Catalogues::durationOptions() as $opt) {
            if ($opt['id'] === $this->durationId) {
                return $opt['months'];
            }
        }

        return 6;
    }

    #[ExposeInTemplate]
    public function getCycleDays(): int
    {
        if ($this->cycleId === 'custom') {
            return max(1, $this->customCycleDays);
        }
        foreach (Catalogues::cycleOptions() as $opt) {
            if ($opt['id'] === $this->cycleId) {
                return $opt['days'];
            }
        }

        return 28;
    }

    #[ExposeInTemplate]
    public function getOrdersCount(): int
    {
        return max(1, (int) round(($this->getDuration() * 30) / $this->getCycleDays()));
    }

    // ── Catalogue helpers ─────────────────────────────────────────────────────

    #[ExposeInTemplate]
    public function getDurationOptions(): array
    {
        return Catalogues::durationOptions();
    }

    #[ExposeInTemplate]
    public function getCycleOptions(): array
    {
        return Catalogues::cycleOptions();
    }

    #[ExposeInTemplate]
    public function getMedicationCatalogue(): array
    {
        return Catalogues::medications();
    }

    #[ExposeInTemplate]
    public function getTitrationCatalogue(): array
    {
        return Catalogues::titrationPaths();
    }

    #[ExposeInTemplate]
    public function getPrescriptionRenewalOptions(): array
    {
        return Catalogues::prescriptionRenewalOptions();
    }

    #[ExposeInTemplate]
    public function getInclusionProducts(): array
    {
        return Catalogues::inclusionProducts();
    }

    #[ExposeInTemplate]
    public function getInclusionCycleOptions(): array
    {
        return Catalogues::inclusionCycleOptions();
    }

    #[ExposeInTemplate]
    public function getAddonProducts(): array
    {
        return Catalogues::addonProducts();
    }

    #[ExposeInTemplate]
    public function getOfferBillingCycleOptions(): array
    {
        return Catalogues::offerBillingCycleOptions();
    }

    // ── Validation ────────────────────────────────────────────────────────────

    #[ExposeInTemplate]
    public function getValidation(): array
    {
        $errors = [];

        if (!trim($this->planName)) {
            $errors['planName'] = 'Plan name is required.';
        }

        $anyMedicationSelected = array_any(
            $this->medications,
            fn ($m) => !empty($m['medicationId'])
        );
        if (!$anyMedicationSelected) {
            $errors['medications'] = 'Add at least one medication.';
        }

        $titrationErrors = array_map(function ($m) {
            if (empty($m['medicationId'])) {
                return null;
            }
            if (!empty($m['titrationEnabled']) && empty($m['titrationPathId'])) {
                return 'Select a titration path for this medication.';
            }

            return null;
        }, $this->medications);

        $hasTitrationError = in_array(true, array_map(fn ($e) => $e !== null, $titrationErrors), true);

        return [
            'errors'          => $errors,
            'titrationErrors' => $titrationErrors,
            'canCreate'       => empty($errors) && !$hasTitrationError,
        ];
    }

    // ── Plan output ───────────────────────────────────────────────────────────

    #[LiveAction]
    public function createPlan(): void
    {
        $this->validate();
        $this->showPlanModal = true;
    }

    #[LiveAction]
    public function closePlanModal(): void
    {
        $this->showPlanModal = false;
    }

    #[ExposeInTemplate]
    public function getPlanJson(): string
    {
        $plan = [
            'id'        => Uuid::v4()->toRfc4122(),
            'createdAt' => (new \DateTimeImmutable())->format(\DateTimeInterface::ATOM),
            'plan'      => [
                'name'     => $this->planName,
                'duration' => [
                    'months'    => $this->getDuration(),
                    'autoRenew' => $this->autoRenew,
                ],
            ],
            'dispatch' => [
                'cycleDays'                => $this->getCycleDays(),
                'ordersCount'              => $this->getOrdersCount(),
                'allowPatientRescheduling' => $this->allowPatientRescheduling,
                'rescheduleDaysEarlier'    => $this->allowPatientRescheduling ? $this->rescheduleDaysEarlier : null,
                'rescheduleDaysLater'      => $this->allowPatientRescheduling ? $this->rescheduleDaysLater : null,
            ],
            'medications' => array_values(array_map(fn ($m) => [
                'productId' => $m['medicationId'],
                'variantId' => $m['variantId'],
                'qty'       => $m['quantityPerOrder'],
                'titration' => $m['titrationEnabled'] ? [
                    'pathId' => $m['titrationPathId'],
                ] : null,
                'prescription' => $m['prescription'],
            ], array_filter($this->medications, fn ($m) => $m['medicationId'] !== ''))),
            'inclusions' => array_values(array_map(fn ($i) => [
                'productId' => $i['productId'],
                'variantId' => $i['variantId'],
                'schedule'  => [
                    'type'            => $i['scheduleType'],
                    'orderNumbers'    => $i['scheduleType'] === 'specific_orders' ? $i['orderNumbers'] : null,
                    'repeatOnRenewal' => $i['scheduleType'] === 'specific_orders' ? $i['repeatOnRenewal'] : null,
                    'cycleId'         => $i['scheduleType'] === 'recurring_cycle' ? $i['cycleId'] : null,
                    'cycleDays'       => $i['scheduleType'] === 'recurring_cycle' ? $i['customCycleDays'] : null,
                ],
            ], array_filter($this->inclusions, fn ($i) => $i['productId'] !== ''))),
            'upsells' => array_values(array_map(fn ($u) => [
                'productId' => $u['productId'],
                'variantId' => $u['variantId'],
                'pricing'   => [
                    'type'        => $u['pricingType'],
                    'customPrice' => $u['pricingType'] === 'custom' ? $u['customPrice'] : null,
                ],
                'schedule' => [
                    'type'         => $u['scheduleType'],
                    'orderNumbers' => $u['scheduleType'] === 'specific_orders' ? $u['orderNumbers'] : null,
                    'cycleId'      => $u['scheduleType'] === 'recurring_cycle' ? $u['cycleId'] : null,
                    'cycleDays'    => $u['scheduleType'] === 'recurring_cycle' ? $u['customCycleDays'] : null,
                ],
            ], array_filter($this->upsells, fn ($u) => $u['productId'] !== ''))),
            'offers' => array_values(array_map(fn ($o) => [
                'type'                => $o['offerType'],
                'price'               => $o['offerType'] === 'fixed_price' ? $o['price'] : null,
                'billingCycleId'      => $o['offerType'] === 'fixed_price' ? $o['billingCycleId'] : null,
                'billingRescheduling' => ($o['offerType'] === 'fixed_price' && $o['allowBillingRescheduling']) ? [
                    'daysEarlier' => $o['billingRescheduleDaysEarlier'],
                    'daysLater'   => $o['billingRescheduleDaysLater'],
                ] : null,
            ], $this->offers)),
        ];

        return json_encode($plan, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    private function newMedicationItem(): array
    {
        return [
            'key'              => Uuid::v4()->toRfc4122(),
            'medicationId'     => '',
            'variantId'        => '',
            'titrationEnabled' => false,
            'titrationPathId'  => '',
            'quantityPerOrder' => 1,
            'prescription'     => [
                'renewalMonths'                => '3',
                'approvalRequiredOnDoseChange' => true,
            ],
        ];
    }

    private function newInclusionItem(): array
    {
        return [
            'key'             => Uuid::v4()->toRfc4122(),
            'productId'       => '',
            'variantId'       => '',
            'scheduleType'    => 'specific_orders',
            'orderNumbers'    => [1],
            'repeatOnRenewal' => false,
            'cycleId'         => '3m',
            'customCycleDays' => 90,
            'prescription'    => [
                'renewalMonths'                => '3',
                'approvalRequiredOnDoseChange' => false,
            ],
        ];
    }

    private function newOfferItem(): array
    {
        return [
            'key'                          => Uuid::v4()->toRfc4122(),
            'offerType'                    => 'basket_value',
            'price'                        => 0.0,
            'billingCycleId'               => 'monthly',
            'customBillingDays'            => 30,
            'allowBillingRescheduling'     => false,
            'billingRescheduleDaysEarlier' => 5,
            'billingRescheduleDaysLater'   => 10,
        ];
    }

    private function newUpsellItem(): array
    {
        return [
            'key'             => Uuid::v4()->toRfc4122(),
            'productId'       => '',
            'variantId'       => '',
            'scheduleType'    => 'specific_orders',
            'orderNumbers'    => [1],
            'cycleId'         => '3m',
            'customCycleDays' => 90,
            'pricingType'     => 'catalogue',
            'customPrice'     => 0.0,
        ];
    }
}
