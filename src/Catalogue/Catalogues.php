<?php

namespace App\Catalogue;

/**
 * Static catalogue data — mirrors src/constants/catalogues.js from the React prototype.
 *
 * All products live in a single products() array.
 * Flags control which sections they appear in:
 *   requiresPrescription  → shown in the Medications section
 *   availableAsInclusion  → shown in the Inclusions section
 *   availableAsUpsell     → shown in the Upsells section
 */
final class Catalogues
{
    // ── Unified product catalogue ─────────────────────────────────────────────

    public static function products(): array
    {
        return [
            // ── Prescription medications ───────────────────────────────────────
            [
                'id'                   => 'mounjaro',
                'name'                 => 'Mounjaro',
                'category'             => 'medication',
                'requiresPrescription' => true,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'mounjaro_2_5mg',  'name' => 'Mounjaro 2.5mg',  'dose' => '2.5mg',  'price' => 89.99],
                    ['id' => 'mounjaro_5mg',    'name' => 'Mounjaro 5mg',    'dose' => '5mg',    'price' => 109.99],
                    ['id' => 'mounjaro_7_5mg',  'name' => 'Mounjaro 7.5mg',  'dose' => '7.5mg',  'price' => 129.99],
                    ['id' => 'mounjaro_10mg',   'name' => 'Mounjaro 10mg',   'dose' => '10mg',   'price' => 149.99],
                    ['id' => 'mounjaro_12_5mg', 'name' => 'Mounjaro 12.5mg', 'dose' => '12.5mg', 'price' => 159.99],
                    ['id' => 'mounjaro_15mg',   'name' => 'Mounjaro 15mg',   'dose' => '15mg',   'price' => 169.99],
                ],
            ],
            [
                'id'                   => 'wegovy',
                'name'                 => 'Wegovy',
                'category'             => 'medication',
                'requiresPrescription' => true,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'wegovy_0_25mg', 'name' => 'Wegovy 0.25mg', 'dose' => '0.25mg', 'price' => 89.99],
                    ['id' => 'wegovy_0_5mg',  'name' => 'Wegovy 0.5mg',  'dose' => '0.5mg',  'price' => 109.99],
                    ['id' => 'wegovy_1mg',    'name' => 'Wegovy 1mg',    'dose' => '1mg',    'price' => 129.99],
                    ['id' => 'wegovy_1_7mg',  'name' => 'Wegovy 1.7mg',  'dose' => '1.7mg',  'price' => 149.99],
                    ['id' => 'wegovy_2_4mg',  'name' => 'Wegovy 2.4mg',  'dose' => '2.4mg',  'price' => 169.99],
                ],
            ],
            [
                'id'                   => 'metformin',
                'name'                 => 'Metformin',
                'category'             => 'medication',
                'requiresPrescription' => true,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'metformin_500mg',  'name' => 'Metformin 500mg',  'dose' => '500mg',  'price' => 12.99],
                    ['id' => 'metformin_850mg',  'name' => 'Metformin 850mg',  'dose' => '850mg',  'price' => 14.99],
                    ['id' => 'metformin_1000mg', 'name' => 'Metformin 1000mg', 'dose' => '1000mg', 'price' => 16.99],
                ],
            ],

            // ── Inclusions (shipped in orders, no extra charge to patient) ─────
            [
                'id'                   => 'cyclizine',
                'name'                 => 'Cyclizine',
                'category'             => 'medication',
                'requiresPrescription' => false,
                'availableAsInclusion' => true,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'cyclizine_50mg', 'name' => 'Cyclizine 50mg', 'price' => 0.00],
                ],
            ],
            [
                'id'                   => 'loperamide',
                'name'                 => 'Loperamide',
                'category'             => 'medication',
                'requiresPrescription' => false,
                'availableAsInclusion' => true,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'loperamide_2mg', 'name' => 'Loperamide 2mg', 'price' => 0.00],
                ],
            ],
            [
                'id'                   => 'welcome_booklet',
                'name'                 => 'Welcome booklet',
                'category'             => 'supply',
                'requiresPrescription' => false,
                'availableAsInclusion' => true,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'welcome_booklet_std', 'name' => 'Welcome booklet (standard)', 'price' => 0.00],
                ],
            ],
            [
                'id'                   => 'sharps_bin',
                'name'                 => 'Sharps bin',
                'category'             => 'supply',
                'requiresPrescription' => false,
                'availableAsInclusion' => true,
                'availableAsUpsell'    => false,
                'variants'             => [
                    ['id' => 'sharps_bin_1l', 'name' => 'Sharps bin (1 litre)',  'price' => 0.00],
                    ['id' => 'sharps_bin_2l', 'name' => 'Sharps bin (2 litres)', 'price' => 0.00],
                ],
            ],

            // ── Upsells (add-ons patients can purchase alongside their plan) ───
            [
                'id'                   => 'anti_nausea',
                'name'                 => 'Anti-nausea medication',
                'category'             => 'medication',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'anti_nausea_std', 'name' => 'Anti-nausea medication', 'price' => 12.99],
                ],
            ],
            [
                'id'                   => 'constipation_support',
                'name'                 => 'Constipation support',
                'category'             => 'medication',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'constipation_support_std', 'name' => 'Constipation support', 'price' => 14.99],
                ],
            ],
            [
                'id'                   => 'alcohol_wipes',
                'name'                 => 'Alcohol wipes',
                'category'             => 'supply',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'alcohol_wipes_50', 'name' => 'Alcohol wipes (50 pack)', 'price' => 3.99],
                ],
            ],
            [
                'id'                   => 'needles',
                'name'                 => 'Needles',
                'category'             => 'supply',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'needles_4mm', 'name' => 'Pen needles 4mm (100 pack)', 'price' => 5.99],
                    ['id' => 'needles_5mm', 'name' => 'Pen needles 5mm (100 pack)', 'price' => 6.49],
                ],
            ],
            [
                'id'                   => 'vitamin_b12',
                'name'                 => 'Vitamin B12',
                'category'             => 'vitamin',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'vitamin_b12_std', 'name' => 'Vitamin B12 (60 tablets)', 'price' => 8.99],
                ],
            ],
            [
                'id'                   => 'vitamin_d3',
                'name'                 => 'Vitamin D3',
                'category'             => 'vitamin',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'vitamin_d3_std', 'name' => 'Vitamin D3 (60 softgels)', 'price' => 9.99],
                ],
            ],
            [
                'id'                   => 'multivitamin',
                'name'                 => 'Multivitamin complex',
                'category'             => 'vitamin',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'multivitamin_std', 'name' => 'Multivitamin complex (60 tablets)', 'price' => 15.99],
                ],
            ],
            [
                'id'                   => 'omega_3',
                'name'                 => 'Omega-3 fish oil',
                'category'             => 'supplement',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'omega_3_std', 'name' => 'Omega-3 fish oil (60 capsules)', 'price' => 11.99],
                ],
            ],
            [
                'id'                   => 'protein_shake',
                'name'                 => 'Protein shake',
                'category'             => 'supplement',
                'requiresPrescription' => false,
                'availableAsInclusion' => false,
                'availableAsUpsell'    => true,
                'variants'             => [
                    ['id' => 'protein_shake_30', 'name' => 'Protein shake (30 servings)', 'price' => 24.99],
                ],
            ],
        ];
    }

    // ── Generic product lookup helpers ─────────────────────────────────────────

    public static function productById(string $id): ?array
    {
        foreach (self::products() as $p) {
            if ($p['id'] === $id) {
                return $p;
            }
        }

        return null;
    }

    public static function variantsByProductId(string $productId): array
    {
        return self::productById($productId)['variants'] ?? [];
    }

    public static function variantById(string $variantId): ?array
    {
        foreach (self::products() as $product) {
            foreach ($product['variants'] as $v) {
                if ($v['id'] === $variantId) {
                    return $v;
                }
            }
        }

        return null;
    }

    // ── Filtered product views ─────────────────────────────────────────────────

    /** Products that require a prescription — used in the Medications section. */
    public static function medications(): array
    {
        return array_values(array_filter(self::products(), fn ($p) => $p['requiresPrescription']));
    }

    /** Products available as order inclusions. */
    public static function inclusionProducts(): array
    {
        return array_values(array_filter(self::products(), fn ($p) => $p['availableAsInclusion']));
    }

    /** Products available as upsells / add-ons. */
    public static function addonProducts(): array
    {
        return array_values(array_filter(self::products(), fn ($p) => $p['availableAsUpsell']));
    }

    // ── Backward-compat medication helpers ────────────────────────────────────

    public static function medicationById(string $id): ?array
    {
        return self::productById($id);
    }

    public static function variantsByMedicationId(string $medicationId): array
    {
        return self::variantsByProductId($medicationId);
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
            fn ($t) => $t['medicationId'] === $medicationId
        ));
    }

    // ── Duration options ──────────────────────────────────────────────────────

    public static function durationOptions(): array
    {
        return [
            ['id' => '3m',     'label' => '3 months',  'months' => 3],
            ['id' => '6m',     'label' => '6 months',  'months' => 6],
            ['id' => '12m',    'label' => '12 months', 'months' => 12],
            ['id' => 'custom', 'label' => 'Custom',    'months' => null],
        ];
    }

    // ── Dispatch cycle options ────────────────────────────────────────────────

    public static function cycleOptions(): array
    {
        return [
            ['id' => '4w',     'label' => 'Every 4 weeks', 'days' => 28],
            ['id' => '2w',     'label' => 'Every 2 weeks', 'days' => 14],
            ['id' => 'monthly', 'label' => 'Monthly',       'days' => 30],
            ['id' => 'custom', 'label' => 'Custom',        'days' => null],
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

    public static function shipmentFrequencyOptions(): array
    {
        return [
            ['id' => '1',  'label' => 'Every shipment'],
            ['id' => '2',  'label' => 'Every 2 shipments'],
            ['id' => '3',  'label' => 'Every 3 shipments'],
            ['id' => '6',  'label' => 'Every 6 shipments'],
            ['id' => '12', 'label' => 'Every 12 shipments'],
        ];
    }

    // ── Inclusion / upsell cycle options ──────────────────────────────────────

    public static function inclusionCycleOptions(): array
    {
        return [
            ['id' => '2w',     'label' => 'Every 2 weeks',  'days' => 14],
            ['id' => '4w',     'label' => 'Every 4 weeks',  'days' => 28],
            ['id' => '3m',     'label' => 'Every 3 months', 'days' => 90],
            ['id' => '6m',     'label' => 'Every 6 months', 'days' => 180],
            ['id' => 'custom', 'label' => 'Custom',         'days' => null],
        ];
    }

    // ── Offer billing cycle options ───────────────────────────────────────────

    public static function offerBillingCycleOptions(): array
    {
        return [
            ['id' => 'monthly', 'label' => 'Monthly',         'days' => 30],
            ['id' => '3m',      'label' => 'Every 3 months',  'days' => 90],
            ['id' => '6m',      'label' => 'Every 6 months',  'days' => 180],
            ['id' => '12m',     'label' => 'Every 12 months', 'days' => 365],
            ['id' => 'custom',  'label' => 'Custom',          'days' => null],
        ];
    }
}
