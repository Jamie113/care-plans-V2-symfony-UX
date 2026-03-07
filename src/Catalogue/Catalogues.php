<?php

namespace App\Catalogue;

/**
 * Static catalogue data — mirrors src/constants/catalogues.js from the React prototype.
 */
final class Catalogues
{
    // ── Medications ──────────────────────────────────────────────────────────

    public static function medications(): array
    {
        return [
            ['id' => 'mounjaro',  'name' => 'Mounjaro',   'variants' => ['2.5mg', '5mg', '7.5mg', '10mg', '12.5mg', '15mg'], 'requiresPrescriptionDefault' => true],
            ['id' => 'wegovy',    'name' => 'Wegovy',     'variants' => ['0.25mg', '0.5mg', '1mg', '1.7mg', '2.4mg'],        'requiresPrescriptionDefault' => true],
            ['id' => 'metformin', 'name' => 'Metformin',  'variants' => ['500mg', '850mg', '1000mg'],                         'requiresPrescriptionDefault' => false],
        ];
    }

    public static function medicationById(string $id): ?array
    {
        foreach (self::medications() as $m) {
            if ($m['id'] === $id) return $m;
        }
        return null;
    }

    // ── Titration paths ───────────────────────────────────────────────────────

    public static function titrationPaths(): array
    {
        return [
            ['id' => 'mounjaro_normal',    'name' => 'Mounjaro — Normal titration',    'medicationId' => 'mounjaro',  'description' => '2.5 → 5 → 7.5 → 10 → 12.5 → 15mg (4-week steps)'],
            ['id' => 'mounjaro_fast',      'name' => 'Mounjaro — Fast titration',      'medicationId' => 'mounjaro',  'description' => '2.5 → 5 → 10 → 15mg (2-week steps)'],
            ['id' => 'mounjaro_advanced',  'name' => 'Mounjaro — Advanced titration',  'medicationId' => 'mounjaro',  'description' => 'Starts at 5mg, escalates to maximum dose'],
            ['id' => 'wegovy_standard',    'name' => 'Wegovy — Standard titration',    'medicationId' => 'wegovy',    'description' => '0.25 → 0.5 → 1 → 1.7 → 2.4mg (4-week steps)'],
            ['id' => 'wegovy_accelerated', 'name' => 'Wegovy — Accelerated titration', 'medicationId' => 'wegovy',    'description' => '0.25 → 1 → 2.4mg (2-week steps)'],
            ['id' => 'metformin_standard', 'name' => 'Metformin — Standard titration', 'medicationId' => 'metformin', 'description' => '500mg → 850mg → 1000mg (2-week steps)'],
        ];
    }

    public static function titrationPathsForMedication(string $medicationId): array
    {
        return array_values(array_filter(
            self::titrationPaths(),
            fn($t) => $t['medicationId'] === $medicationId
        ));
    }

    // ── Add-ons (upsells) ─────────────────────────────────────────────────────

    public static function addons(): array
    {
        return [
            ['id' => 'anti_nausea',          'name' => 'Anti-nausea medication',   'category' => 'medication',  'price' => 12.99],
            ['id' => 'constipation_support', 'name' => 'Constipation support',     'category' => 'medication',  'price' => 14.99],
            ['id' => 'alcohol_wipes',        'name' => 'Alcohol wipes',            'category' => 'supply',      'price' => 3.99],
            ['id' => 'needles',              'name' => 'Needles',                   'category' => 'supply',      'price' => 5.99],
            ['id' => 'vitamin_b12',          'name' => 'Vitamin B12',              'category' => 'vitamin',     'price' => 8.99],
            ['id' => 'vitamin_d3',           'name' => 'Vitamin D3',               'category' => 'vitamin',     'price' => 9.99],
            ['id' => 'multivitamin',         'name' => 'Multivitamin complex',     'category' => 'vitamin',     'price' => 15.99],
            ['id' => 'omega_3',              'name' => 'Omega-3 fish oil',         'category' => 'vitamin',     'price' => 11.99],
            ['id' => 'protein_shake',        'name' => 'Protein shake (30 srv.)',  'category' => 'supplement',  'price' => 24.99],
        ];
    }

    public static function addonById(string $id): ?array
    {
        foreach (self::addons() as $a) {
            if ($a['id'] === $id) return $a;
        }
        return null;
    }

    // ── Inclusions ────────────────────────────────────────────────────────────

    public static function inclusions(): array
    {
        return [
            ['id' => 'cyclizine',       'name' => 'Cyclizine',        'description' => 'Anti-nausea medication',     'isMedication' => true],
            ['id' => 'loperamide',      'name' => 'Loperamide',       'description' => 'Anti-diarrhoeal medication',  'isMedication' => true],
            ['id' => 'welcome_booklet', 'name' => 'Welcome booklet',  'description' => 'Onboarding materials',        'isMedication' => false],
            ['id' => 'sharps_bin',      'name' => 'Sharps bin',       'description' => 'Safe needle disposal',        'isMedication' => false],
        ];
    }

    public static function inclusionById(string $id): ?array
    {
        foreach (self::inclusions() as $i) {
            if ($i['id'] === $id) return $i;
        }
        return null;
    }

    // ── Duration options ──────────────────────────────────────────────────────

    public static function durationOptions(): array
    {
        return [
            ['id' => '3m',     'label' => '3 months',   'months' => 3],
            ['id' => '6m',     'label' => '6 months',   'months' => 6],
            ['id' => '12m',    'label' => '12 months',  'months' => 12],
            ['id' => 'custom', 'label' => 'Custom',     'months' => null],
        ];
    }

    // ── Dispatch cycle options ────────────────────────────────────────────────

    public static function cycleOptions(): array
    {
        return [
            ['id' => '4w',     'label' => 'Every 4 weeks',  'days' => 28],
            ['id' => '2w',     'label' => 'Every 2 weeks',  'days' => 14],
            ['id' => 'monthly','label' => 'Monthly',        'days' => 30],
            ['id' => 'custom', 'label' => 'Custom',         'days' => null],
        ];
    }

    // ── Prescription renewal options ──────────────────────────────────────────

    public static function prescriptionRenewalOptions(): array
    {
        return [
            ['id' => '1',  'months' => 1,  'label' => '1 month'],
            ['id' => '2',  'months' => 2,  'label' => '2 months'],
            ['id' => '3',  'months' => 3,  'label' => '3 months'],
            ['id' => '6',  'months' => 6,  'label' => '6 months'],
            ['id' => '12', 'months' => 12, 'label' => '12 months'],
        ];
    }

    // ── Inclusion cycle options ───────────────────────────────────────────────

    public static function inclusionCycleOptions(): array
    {
        return [
            ['id' => '2w',     'label' => 'Every 2 weeks',   'days' => 14],
            ['id' => '4w',     'label' => 'Every 4 weeks',   'days' => 28],
            ['id' => '3m',     'label' => 'Every 3 months',  'days' => 90],
            ['id' => '6m',     'label' => 'Every 6 months',  'days' => 180],
            ['id' => 'custom', 'label' => 'Custom',          'days' => null],
        ];
    }

    // ── Offer billing cycle options ───────────────────────────────────────────

    public static function offerBillingCycleOptions(): array
    {
        return [
            ['id' => 'monthly', 'label' => 'Monthly',          'days' => 30],
            ['id' => '3m',      'label' => 'Every 3 months',   'days' => 90],
            ['id' => '6m',      'label' => 'Every 6 months',   'days' => 180],
            ['id' => '12m',     'label' => 'Every 12 months',  'days' => 365],
            ['id' => 'custom',  'label' => 'Custom',           'days' => null],
        ];
    }
}
