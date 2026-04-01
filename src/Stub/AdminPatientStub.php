<?php

namespace App\Stub;

final class AdminPatientStub
{
    public static function all(): array
    {
        return [
            self::make('PLN-001', 'CUS-001', 'Weightloss', 89.00, 1,  'Sarah Mitchell',   'sarah.mitchell@email.com',  '07700 900 123', '1988-03-12', 'WL Starter 6 Month',       'Mounjaro',  '2.5mg',  'active',            '2026-01-15', '2026-04-03', '2026-03-06', '2026-04-03', '2026-03-06', 3,  6,  28, 89.00,  null,            [['2026-03-28', 'order_date_changed',  'Order date changed from 28 Mar to 3 Apr',   'Admin'],  ['2026-03-06', 'order_dispatched', 'Order #3 dispatched', 'System'], ['2026-02-06', 'order_dispatched', 'Order #2 dispatched', 'System'], ['2026-01-15', 'plan_started', 'Plan started', 'System']], '2.5mg', '5mg', 89.00, false, '2026-07-02', [['ORD-003','TRK-SM003','delivered','2026-03-06','Mounjaro 2.5mg ×1'],['ORD-002','TRK-SM002','delivered','2026-02-06','Mounjaro 2.5mg ×1'],['ORD-001','TRK-SM001','delivered','2026-01-15','Mounjaro 2.5mg ×1']]),
            self::make('PLN-002', 'CUS-002', 'Weightloss', 134.10, 2,  'James Thornton',   'j.thornton@gmail.com',      '07700 900 456', '1979-07-22', 'WL Advanced 12 Month',     'Wegovy',    '0.25mg', 'active',            '2025-11-01', '2026-04-06', '2026-03-09', '2026-04-06', '2026-03-09', 5,  13, 28, 149.00, '10% loyalty',   [['2026-03-29', 'discount_applied',   '10% loyalty discount applied',              'Admin'],  ['2026-03-09', 'order_dispatched', 'Order #5 dispatched', 'System'], ['2026-02-09', 'order_dispatched', 'Order #4 dispatched', 'System'], ['2025-11-01', 'plan_started', 'Plan started', 'System']], '0.25mg', '0.5mg', 149.00, false, '2026-10-31', [['ORD-005','TRK-JT005','in-transit','2026-03-09','Wegovy 0.25mg ×1'],['ORD-004','TRK-JT004','delivered','2026-02-09','Wegovy 0.25mg ×1']], 'M', [], 0, [['Vitamin B12 booster', 14.99, 'active', '2026-04-06'], ['Mindful eating programme', 9.99, 'active', '2026-04-06']]),
            self::make('PLN-003', 'CUS-003', 'Weightloss', 119.00, 3,  'Emma Clarke',      'emma.clarke@hotmail.com',   '07700 900 789', '1994-11-05', 'WL Pro 3 Month',           'Mounjaro',  '5mg',    'active',            '2026-02-01', '2026-04-01', '2026-03-01', '2026-04-01', '2026-03-01', 2,  3,  28, 119.00, null,            [['2026-03-27', 'order_dispatched',   'Order #2 dispatched',                       'System'], ['2026-03-01', 'order_dispatched', 'Order #1 dispatched', 'System'], ['2026-02-01', 'plan_started', 'Plan started', 'System']], '5mg', '5mg', 119.00, false, '2026-04-26', [['ORD-002','TRK-EC002','delivered','2026-03-01','Mounjaro 5mg ×1'],['ORD-001','TRK-EC001','delivered','2026-02-01','Mounjaro 5mg ×1']]),
            self::make('PLN-004', 'CUS-004', 'Weightloss', 89.00, 4,  'David Hughes',     'd.hughes@work.co.uk',       '07700 900 321', '1972-05-30', 'WL Starter 6 Month',       'Wegovy',    '0.5mg',  'deactivated',       '2026-01-08', null,         '2026-02-05', null,         '2026-02-05', 2,  6,  28, 89.00,  null,            [['2026-03-25', 'plan_paused',        'Plan paused — patient requested break',     'Admin'],  ['2026-02-05', 'order_dispatched', 'Order #2 dispatched', 'System'], ['2026-01-08', 'order_dispatched', 'Order #1 dispatched', 'System'], ['2026-01-08', 'plan_started', 'Plan started', 'System']], '0.5mg', null, 89.00, false, null, [['ORD-002','TRK-DH002','delivered','2026-02-05','Wegovy 0.5mg ×1'],['ORD-001','TRK-DH001','delivered','2026-01-08','Wegovy 0.5mg ×1']]),
            self::make('PLN-005', 'CUS-005', 'Weightloss', 149.00, 5,  'Priya Patel',      'priya.patel@nhs.net',       '07700 900 654', '1991-02-18', 'WL Advanced 12 Month',     'Mounjaro',  '2.5mg',  'requested-change',  '2025-10-15', '2026-04-08', '2026-03-11', '2026-04-08', '2026-03-11', 6,  13, 28, 149.00, null,            [['2026-03-22', 'plan_changed',       'Dose increased from 2.5mg to 5mg next cycle','Admin'],  ['2026-03-11', 'order_dispatched', 'Order #6 dispatched', 'System'], ['2026-02-11', 'order_dispatched', 'Order #5 dispatched', 'System'], ['2025-10-15', 'plan_started', 'Plan started', 'System']], '2.5mg', '5mg', 149.00, false, '2026-10-14', [['ORD-006','TRK-PP006','delivered','2026-03-11','Mounjaro 2.5mg ×1'],['ORD-005','TRK-PP005','delivered','2026-02-11','Mounjaro 2.5mg ×1']], 'F', [], 0, [], '7.5mg'),
            self::make('PLN-006', 'CUS-006', 'TRT', 129.00, 6,  'Michael Foster',   'mfoster82@gmail.com',       '07700 900 987', '1982-09-14', 'Testosterone 6 Month',     'Testogel',  '50mg',   'active',            '2026-01-20', '2026-04-07', '2026-03-10', '2026-04-07', '2026-03-10', 3,  6,  28, 129.00, null,            [['2026-03-26', 'order_dispatched',   'Order #3 dispatched',                       'System'], ['2026-03-10', 'order_dispatched', 'Order #2 dispatched', 'System'], ['2026-01-20', 'plan_started', 'Plan started', 'System']], '50mg', '50mg', 129.00, false, '2026-07-07', [['ORD-003','TRK-MF003','delivered','2026-03-10','Testogel 50mg ×1'],['ORD-002','TRK-MF002','delivered','2026-02-10','Testogel 50mg ×1']], 'M', [], 56),
            self::make('PLN-007', 'CUS-007', 'Weightloss', 89.00, 7,  'Laura Bennett',    'laurabennett@icloud.com',   '07700 900 111', '1996-06-27', 'WL Starter 6 Month',       'Wegovy',    '0.25mg', 'active',            '2026-02-15', '2026-04-26', '2026-03-29', '2026-04-26', '2026-03-29', 2,  6,  28, 89.00,  null,            [['2026-03-29', 'order_dispatched',   'Order #2 dispatched',                       'System'], ['2026-03-01', 'order_dispatched', 'Order #1 dispatched', 'System'], ['2026-02-15', 'plan_started', 'Plan started', 'System']], '0.25mg', '0.5mg', 89.00, false, '2026-08-02', [['ORD-002','TRK-LB002','delivered','2026-03-29','Wegovy 0.25mg ×1'],['ORD-001','TRK-LB001','delivered','2026-03-01','Wegovy 0.25mg ×1']]),
            self::make('PLN-008', 'CUS-008', 'Weightloss', 119.00, 8,  'Tom Walsh',        'tomwalsh@outlook.com',      '07700 900 222', '1985-12-03', 'WL Pro 3 Month',           'Mounjaro',  '7.5mg',  'active',            '2026-01-28', '2026-04-05', '2026-03-04', '2026-04-05', '2026-03-04', 2,  3,  28, 119.00, null,            [['2026-03-30', 'billing_date_changed','Billing date adjusted to match order date',  'Admin'],  ['2026-03-04', 'order_dispatched', 'Order #2 dispatched', 'System'], ['2026-01-28', 'plan_started', 'Plan started', 'System']], '7.5mg', '10mg', 119.00, false, '2026-04-22', [['ORD-003','TRK-TW003','processing','2026-04-05','Mounjaro 10mg ×1'],['ORD-002','TRK-TW002','delivered','2026-03-04','Mounjaro 7.5mg ×1']]),
            self::make('PLN-009', 'CUS-009', 'Weightloss', 149.00, 9,  'Grace Cooper',     'grace.cooper@email.com',    '07700 900 333', '1990-04-09', 'WL Advanced 12 Month',     'Mounjaro',  '5mg',    'requested-approve', '2025-12-01', '2026-04-21', '2026-03-24', '2026-04-21', '2026-03-24', 4,  13, 28, 149.00, null,            [['2026-03-24', 'order_dispatched',   'Order #4 dispatched',                       'System'], ['2026-02-24', 'order_dispatched', 'Order #3 dispatched', 'System'], ['2025-12-01', 'plan_started', 'Plan started', 'System']], '5mg', '7.5mg', 149.00, false, '2026-11-30', [['ORD-004','TRK-GC004','delivered','2026-03-24','Mounjaro 5mg ×1'],['ORD-003','TRK-GC003','delivered','2026-02-24','Mounjaro 5mg ×1']]),
            self::make('PLN-010', 'CUS-010', 'Weightloss', 89.00, 10, 'Ryan Morris',      'r.morris@yahoo.co.uk',      '07700 900 444', '1977-08-16', 'WL Starter 6 Month',       'Wegovy',    '0.25mg', 'expired',           '2025-11-15', null,         '2026-02-10', null,         '2026-02-10', 3,  6,  28, 89.00,  null,            [['2026-03-16', 'plan_cancelled',     'Plan cancelled — patient request',          'Admin'],  ['2026-02-10', 'order_dispatched', 'Order #3 dispatched', 'System'], ['2025-11-15', 'plan_started', 'Plan started', 'System']], '0.25mg', null, 0.00, true, null, [['ORD-003','TRK-RM003','failed','2026-02-10','Wegovy 0.25mg ×1'],['ORD-002','TRK-RM002','delivered','2025-12-15','Wegovy 0.25mg ×1'],['ORD-001','TRK-RM001','delivered','2025-11-15','Wegovy 0.25mg ×1']]),
            self::make('PLN-011', 'CUS-011', 'Weightloss', 126.65, 11, 'Charlotte Evans',  'charlotte.e@gmail.com',     '07700 900 555', '1993-01-21', 'WL Advanced 12 Month',     'Mounjaro',  '2.5mg',  'active',            '2025-10-01', '2026-04-02', '2026-03-05', '2026-04-02', '2026-03-05', 7,  13, 28, 149.00, '15% retention', [['2026-03-27', 'discount_applied',   '15% retention discount applied for 3 months','Admin'],  ['2026-03-05', 'order_dispatched', 'Order #7 dispatched', 'System'], ['2026-02-05', 'order_dispatched', 'Order #6 dispatched', 'System'], ['2025-10-01', 'plan_started', 'Plan started', 'System']], '2.5mg', '5mg', 149.00, false, '2026-09-30', [['ORD-007','TRK-CE007','delivered','2026-03-05','Mounjaro 2.5mg ×1'],['ORD-006','TRK-CE006','delivered','2026-02-05','Mounjaro 2.5mg ×1']]),
            self::make('PLN-012', 'CUS-012', 'TRT', 129.00, 12, 'Oliver Shaw',      'oshaw@work.com',            '07700 900 666', '1983-10-07', 'Testosterone 6 Month',     'Testogel',  '50mg',   'active',            '2026-01-05', '2026-04-07', '2026-03-10', '2026-04-07', '2026-03-10', 3,  6,  28, 129.00, null,            [['2026-03-25', 'one_off_order',      'One-off order sent — Vitamin D supplement', 'Admin'],  ['2026-03-10', 'order_dispatched', 'Order #3 dispatched', 'System'], ['2026-01-05', 'plan_started', 'Plan started', 'System']], '50mg', '50mg', 129.00, false, '2026-06-22', [['ORD-003','TRK-OS003','delivered','2026-03-10','Testogel 50mg ×1'],['ORD-002','TRK-OS002','delivered','2026-02-10','Testogel 50mg ×1']]),
            self::make('PLN-013', 'CUS-013', 'Weightloss', 89.00, 13, 'Amelia Young',     'amelia.young@me.com',       '07700 900 777', '1999-04-14', 'WL Starter 6 Month',       'Mounjaro',  '2.5mg',  'requested-approve', '2026-04-06', '2026-04-06', null,         '2026-04-06', null,         0,  6,  28, 89.00,  null,            [['2026-03-23', 'plan_created',       'Plan created, pending first order',         'Admin']], null, '2.5mg', 0.00, false, '2026-10-01', []),
            self::make('PLN-014', 'CUS-014', 'Weightloss', 119.00, 14, 'Harry Thompson',   'hthompson@hotmail.com',     '07700 900 888', '1987-06-19', 'WL Pro 3 Month',           'Wegovy',    '1mg',    'deactivated',       '2026-02-10', null,         '2026-03-10', null,         '2026-03-10', 2,  3,  28, 119.00, null,            [['2026-03-27', 'plan_paused',        'Plan paused — adverse reaction reported',  'Admin'],  ['2026-03-10', 'order_dispatched', 'Order #2 dispatched', 'System'], ['2026-02-10', 'plan_started', 'Plan started', 'System']], '1mg', null, 119.00, false, null, [['ORD-002','TRK-HT002','delivered','2026-03-10','Wegovy 1mg ×1'],['ORD-001','TRK-HT001','delivered','2026-02-10','Wegovy 1mg ×1']]),
            self::make('PLN-015', 'CUS-015', 'Weightloss', 149.00, 15, 'Sophie Williams',  'swilliams@gmail.com',       '07700 900 999', '1992-09-30', 'WL Advanced 12 Month',     'Mounjaro',  '10mg',   'requested-renew',   '2025-09-01', '2026-04-25', '2026-03-28', '2026-04-25', '2026-03-28', 9,  13, 28, 149.00, null,            [['2026-03-28', 'order_dispatched',   'Order #9 dispatched',                       'System'], ['2026-02-28', 'order_dispatched', 'Order #8 dispatched', 'System'], ['2025-09-01', 'plan_started', 'Plan started', 'System']], '10mg', '12.5mg', 149.00, false, '2026-08-31', [['ORD-009','TRK-SW009','in-transit','2026-03-28','Mounjaro 10mg ×1'],['ORD-008','TRK-SW008','delivered','2026-02-28','Mounjaro 10mg ×1']]),
            self::make('PLN-016', 'CUS-016', 'Weightloss', 89.00, 16, 'Lucas Brown',      'lucas.brown@icloud.com',    '07700 900 100', '1995-02-25', 'WL Starter 6 Month',       'Wegovy',    '0.5mg',  'deactivated',       '2025-12-15', null,         '2026-02-25', null,         '2026-02-25', 3,  6,  28, 89.00,  null,            [['2026-03-20', 'plan_paused',        'Plan paused — payment issue',              'Admin'],  ['2026-02-25', 'order_dispatched', 'Order #3 dispatched', 'System'], ['2025-12-15', 'plan_started', 'Plan started', 'System']], '0.5mg', null, 0.00, true, null, [['ORD-003','TRK-LBR003','failed','2026-02-25','Wegovy 0.5mg ×1'],['ORD-002','TRK-LBR002','delivered','2026-01-25','Wegovy 0.5mg ×1']]),
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
            // Sophie Williams (CUS-015) — WL Pro 3 Month before her current Advanced 12 Month
            self::make('PLN-015-H', 'CUS-015', 'Weightloss', 0.00, 152, 'Sophie Williams', 'swilliams@gmail.com', '07700 900 999', '1992-09-30', 'WL Pro 3 Month', 'Mounjaro', '5mg', 'expired', '2025-06-01', null, '2025-08-30', null, '2025-08-30', 3, 3, 28, 119.00, null, [['2025-08-30', 'plan_completed', 'All 3 orders shipped — plan completed', 'System'], ['2025-06-01', 'plan_started', 'Plan started', 'System']], '5mg', null, 119.00, false, null, [['ORD-003', 'TRK-SWH003', 'delivered', '2025-08-30', 'Mounjaro 5mg ×1'], ['ORD-001', 'TRK-SWH001', 'delivered', '2025-06-01', 'Mounjaro 5mg ×1']]),
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
