<?php

namespace App\Stub;

final class AdminPatientStub
{
    public static function all(): array
    {
        return [
            self::make('PLN-001', 'CUS-001', 'Weightloss', 89.00, 1,  'Sarah Mitchell',   'sarah.mitchell@email.com',  '07700 900 123', '1988-03-12', 'WL Starter 6 Month',       'Mounjaro',  '2.5mg',  'active',            '2026-01-15', '2026-04-03', '2026-03-06', '2026-04-03', '2026-03-06', 3,  6,  28, 89.00,  null,            [['2026-03-28', 'order_date_changed',  'Order date changed from 28 Mar to 3 Apr',   'Admin'],  ['2026-03-06', 'order_dispatched', 'Order #3 dispatched', 'System'], ['2026-02-06', 'order_dispatched', 'Order #2 dispatched', 'System'], ['2026-01-15', 'plan_started', 'Plan started', 'System']], '2.5mg', '5mg', 89.00, false, '2026-07-02', [['ORD-003','TRK-SM003','delivered','2026-03-06','Mounjaro 2.5mg ×1'],['ORD-002','TRK-SM002','delivered','2026-02-06','Mounjaro 2.5mg ×1'],['ORD-001','TRK-SM001','delivered','2026-01-15','Mounjaro 2.5mg ×1']]),
            self::make('PLN-002', 'CUS-002', 'Weightloss', 134.10, 2,  'James Thornton',   'j.thornton@gmail.com',      '07700 900 456', '1979-07-22', 'WL Advanced 12 Month',     'Wegovy',    '0.25mg', 'active',            '2025-11-01', '2026-04-06', '2026-03-09', '2026-04-06', '2026-03-09', 5,  13, 28, 149.00, '10% loyalty',   [['2026-03-29', 'discount_applied',   '10% loyalty discount applied',              'Admin'],  ['2026-03-09', 'order_dispatched', 'Order #5 dispatched', 'System'], ['2026-02-09', 'order_dispatched', 'Order #4 dispatched', 'System'], ['2025-11-01', 'plan_started', 'Plan started', 'System']], '0.25mg', '0.5mg', 149.00, false, '2026-10-31', [['ORD-005','TRK-JT005','in-transit','2026-03-09','Wegovy 0.25mg ×1'],['ORD-004','TRK-JT004','delivered','2026-02-09','Wegovy 0.25mg ×1']], 'M', [], 0, [['Vitamin B12 booster', 14.99, 'active', '2026-04-06'], ['Mindful eating programme', 9.99, 'active', '2026-04-06']]),
        ];
    }

    /**
     * Historical plans for patients who have had more than one care plan.
     * Shown on the patient detail page but not in the main patient list.
     */
    private static function historicalPlansData(): array
    {
        return [
            // James Thornton (CUS-002) — WL Starter 6 Month before his current Advanced 12 Month
            self::make('PLN-002-H', 'CUS-002', 'Weightloss', 0.00, 102, 'James Thornton', 'j.thornton@gmail.com', '07700 900 456', '1979-07-22', 'WL Starter 6 Month', 'Wegovy', '0.25mg', 'expired', '2025-05-01', null, '2025-10-28', null, '2025-10-28', 6, 6, 28, 89.00, null, [['2025-10-28', 'plan_completed', 'All 6 orders shipped — plan completed', 'System'], ['2025-05-01', 'plan_started', 'Plan started', 'System']], '0.25mg', null, 89.00, false, null, [['ORD-006', 'TRK-JTH006', 'delivered', '2025-10-28', 'Wegovy 0.25mg ×1'], ['ORD-001', 'TRK-JTH001', 'delivered', '2025-05-01', 'Wegovy 0.25mg ×1']]),
        ];
    }

    /**
     * Returns one row per patient (their current/latest plan), with planCount added.
     * Used by the patient list page.
     */
    public static function allPatients(): array
    {
        $current    = self::all();
        $historical = self::historicalPlansData();

        // Count total plans per customer (current + historical)
        $planCounts = [];
        foreach (array_merge($current, $historical) as $p) {
            $planCounts[$p['customerId']] = ($planCounts[$p['customerId']] ?? 0) + 1;
        }

        return array_map(static function (array $p) use ($planCounts): array {
            $p['planCount'] = $planCounts[$p['customerId']] ?? 1;
            return $p;
        }, $current);
    }

    /**
     * Returns patient info and all their plans (current first, historical after).
     * Used by the patient detail page.
     */
    public static function findByCustomerId(string $customerId): ?array
    {
        $currentPlan = null;
        foreach (self::all() as $plan) {
            if ($plan['customerId'] === $customerId) {
                $currentPlan = $plan;
                break;
            }
        }

        if (!$currentPlan) {
            return null;
        }

        $allPlans = [$currentPlan];
        foreach (self::historicalPlansData() as $plan) {
            if ($plan['customerId'] === $customerId) {
                $allPlans[] = $plan;
            }
        }

        return [
            'customerId' => $currentPlan['customerId'],
            'name'       => $currentPlan['patientName'],
            'email'      => $currentPlan['patientEmail'],
            'phone'      => $currentPlan['patientPhone'],
            'dob'        => $currentPlan['patientDob'],
            'gender'     => $currentPlan['gender'],
            'plans'      => $allPlans,
        ];
    }

    public static function findById(int $id): ?array
    {
        foreach (array_merge(self::all(), self::historicalPlansData()) as $plan) {
            if ($plan['id'] === $id) {
                return $plan;
            }
        }

        return null;
    }

    public static function stats(): array
    {
        $plans = self::all();

        return [
            'total'       => count($plans),
            'active'      => count(array_filter($plans, fn($p) => 'active' === $p['status'])),
            'deactivated' => count(array_filter($plans, fn($p) => 'deactivated' === $p['status'])),
            'expired'     => count(array_filter($plans, fn($p) => 'expired' === $p['status'])),
            'needsAction' => count(array_filter($plans, fn($p) => in_array($p['status'], ['requested-renew', 'requested-change', 'requested-approve'], true))),
        ];
    }

    private static function make(
        string $planId,
        string $customerId,
        string $category,
        float $nextPaymentAmount,
        int $id,
        string $name,
        string $email,
        string $phone,
        string $dob,
        string $plan,
        string $medication,
        string $variant,
        string $status,
        string $startDate,
        ?string $nextOrderDate,
        ?string $lastOrderDate,
        ?string $nextBillingDate,
        ?string $lastBillingDate,
        int $ordersCompleted,
        int $ordersTotal,
        int $cycleDays,
        float $price,
        ?string $discount,
        array $activity,
        ?string $currentDose,
        ?string $nextDose,
        float $lastPaymentAmount,
        bool $paymentFailed,
        ?string $renewalDate,
        array $shipments,
        // Optional enrichment fields
        string $gender = 'Not recorded',
        array $inclusions = [],
        int $billingCycleDays = 0,   // 0 = billed with each order (same as cycleDays)
        array $upsells = [],
        ?string $patientRequestedDose = null,
    ): array {
        // Derive inclusions from category when not explicitly provided
        if (empty($inclusions)) {
            $inclusions = match ($category) {
                'Weightloss' => ['Monthly clinical check-in', 'Progress tracking app access', 'Nutritional guidance pack'],
                'TRT'        => ['Quarterly blood test kit', 'Monthly clinical check-in'],
                default      => [],
            };
        }

        $billingCycleDays = $billingCycleDays > 0 ? $billingCycleDays : $cycleDays;

        // Titration schedule per medication
        $titrationSchedules = [
            'Mounjaro' => ['2.5mg', '5mg', '7.5mg', '10mg', '12.5mg', '15mg'],
            'Wegovy'   => ['0.25mg', '0.5mg', '1mg', '1.7mg', '2.4mg'],
            'Ozempic'  => ['0.25mg', '0.5mg', '1mg', '2mg'],
            'Testogel' => ['25mg', '50mg', '75mg', '100mg'],
        ];

        return [
            'planId'             => $planId,
            'customerId'         => $customerId,
            'category'           => $category,
            'nextPaymentAmount'  => $nextPaymentAmount,
            'id'               => $id,
            'patientName'      => $name,
            'patientEmail'     => $email,
            'patientPhone'     => $phone,
            'patientDob'       => $dob,
            'gender'           => $gender,
            'planName'         => $plan,
            'medication'       => $medication,
            'variant'          => $variant,
            'status'           => $status,
            'startDate'        => $startDate,
            'nextOrderDate'    => $nextOrderDate,
            'lastOrderDate'    => $lastOrderDate,
            'nextBillingDate'  => $nextBillingDate,
            'lastBillingDate'  => $lastBillingDate,
            'ordersCompleted'  => $ordersCompleted,
            'ordersTotal'      => $ordersTotal,
            'cycleDays'        => $cycleDays,
            'price'            => $price,
            'discount'         => $discount,
            'activity'         => array_map(fn($a) => [
                'date'        => $a[0],
                'type'        => $a[1],
                'description' => $a[2],
                'agent'       => $a[3],
            ], $activity),
            'currentDose'        => $currentDose,
            'nextDose'           => $nextDose,
            'lastPaymentAmount'  => $lastPaymentAmount,
            'paymentFailed'      => $paymentFailed,
            'renewalDate'        => $renewalDate,
            'shipments'          => array_map(fn($s) => [
                'orderNumber' => $s[0],
                'trackingRef' => $s[1],
                'status'      => $s[2],
                'date'        => $s[3],
                'items'       => $s[4],
            ], $shipments),
            'inclusions'         => $inclusions,
            'billingCycleDays'   => $billingCycleDays,
            'billingMatchesOrder'=> $billingCycleDays === $cycleDays,
            'upsells'            => array_map(fn($u) => [
                'name'          => $u[0],
                'price'         => $u[1],
                'status'        => $u[2],
                'nextOrderDate' => $u[3] ?? null,
            ], $upsells),
            // Medications list — supports multiple products per plan in future
            'medications' => [
                [
                    'name'                  => $medication,
                    'variant'               => $variant,
                    'currentDose'           => $currentDose,
                    'nextDose'              => $nextDose,
                    'patientRequestedDose'  => $patientRequestedDose,
                    'titrationSchedule'     => $titrationSchedules[$medication] ?? [],
                    'isTitrating'           => $nextDose !== null && $nextDose !== $currentDose,
                ],
            ],
        ];
    }
}
