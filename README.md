# Treatment Plan Builder — Prototype

A Symfony UX Live Component prototype for configuring treatment plans. Built to give the engineering team a concrete, interactive reference for defining scope of work.

---

## Purpose

This is a **non-production prototype**. Its job is to:

- Show how a treatment plan is structured (medications, dispatch, inclusions, upsells, offers)
- Define the JSON API contract the real system will need to accept
- Surface engineering scope via code comments on every card section
- Let stakeholders interact with the UI rather than read a static spec

The "Create Plan" button produces a JSON payload (visible in the modal and in the dev data schema panel at the bottom of the page) — this is the proposed API contract, not a real API call.

---

## Stack

| Layer | Technology |
|---|---|
| Framework | Symfony 8.0 (PHP ≥ 8.4) |
| Reactivity | [Symfony UX Live Components](https://symfony.com/bundles/ux-live-component/current/index.html) |
| Templates | Twig + Tailwind CSS (via CDN) |
| State | Single `TreatmentPlanBuilder` Live Component — all state in LiveProps |
| UIDs | `symfony/uid` — `Uuid::v4()->toRfc4122()` for all item keys |
| Code style | PHP CS Fixer (`friendsofphp/php-cs-fixer`) — config in `.php-cs-fixer.php` |

---

## Setup

```bash
# 1. Install PHP dependencies
composer install

# 2. Install JS dependencies
npm install          # or yarn

# 3. Build assets
npm run dev          # or npm run watch for hot-reload

# 4. Start the dev server
symfony serve        # or php -S localhost:8000 -t public/
```

The app has no database requirement — all state is in-memory (LiveProps). No `.env` changes needed.

---

## Architecture

### Component: `TreatmentPlanBuilder`

**File:** `src/Twig/Components/TreatmentPlanBuilder.php`
**Template:** `templates/components/TreatmentPlanBuilder.html.twig`

The entire builder is a single Symfony UX Live Component. Every user interaction triggers an AJAX re-render — no custom JavaScript needed.

#### State (LiveProps)

| Prop | Type | Description |
|---|---|---|
| `$planName` | `string` | Plan display name |
| `$durationId` | `string` | Selected preset (`3m`, `6m`, `12m`, `custom`) |
| `$customDurationMonths` | `int` | Used when `durationId === 'custom'` |
| `$autoRenew` | `bool` | Restart plan at end of duration |
| `$startBehaviour` | `string` | `immediately` or `future_date` |
| `$startDate` | `string` | ISO date string |
| `$cycleId` | `string` | Dispatch cycle preset |
| `$customCycleDays` | `int` | Used when `cycleId === 'custom'` |
| `$allowPatientRescheduling` | `bool` | Allow patient to shift dispatch date |
| `$rescheduleDaysEarlier` | `int` | Max days patient can move order earlier |
| `$rescheduleDaysLater` | `int` | Max days patient can move order later |
| `$medications` | `array` | Array of medication item arrays |
| `$inclusions` | `array` | Array of inclusion item arrays |
| `$offers` | `array` | Array of offer item arrays |
| `$upsells` | `array` | Array of upsell item arrays |
| `$showPlanModal` | `bool` | Controls the Create Plan JSON modal |

#### Computed values (`#[ExposeInTemplate]`)

| Method | Returns | Notes |
|---|---|---|
| `getDuration()` | `int` (months) | Resolves preset or custom value |
| `getCycleDays()` | `int` (days) | Resolves preset or custom value |
| `getOrdersCount()` | `int` | `round((months × 30) ÷ cycleDays)` |
| `getValidation()` | `array` | `errors`, `titrationErrors`, `canCreate` |
| `getPlanJson()` | `string` | Full JSON API contract payload |

#### Key LiveActions

| Action | Purpose |
|---|---|
| `addMedication / removeMedication` | Add/remove medication row |
| `setMedicationProduct` | Select medication; clears variant |
| `setMedicationVariant` | Select variant for a medication |
| `addInclusion / removeInclusion` | Add/remove inclusion row |
| `setInclusionProduct` | Select inclusion product; clears variant |
| `setInclusionScheduleType` | Toggle specific_orders / recurring_cycle |
| `toggleInclusionOrder` | Toggle an order number pill on/off |
| `addUpsell / removeUpsell` | Add/remove upsell row |
| `setUpsellProduct` | Select upsell product; clears variant |
| `setUpsellScheduleType` | Toggle add-to-plan-orders / unique-recurring-cycle |
| `setUpsellPricingType` | Toggle catalogue / custom price |
| `addOffer / removeOffer` | Add/remove offer row |
| `createPlan` | Validate + set `showPlanModal = true` |
| `closePlanModal` | Set `showPlanModal = false` |

---

### Catalogue: `Catalogues`

**File:** `src/Catalogue/Catalogues.php`

Static stub returning all product data. The real system replaces this with calls to a product/formulary service.

#### Product flags

Every product in `products()` carries three boolean flags that control which section of the UI it appears in:

| Flag | Meaning |
|---|---|
| `requiresPrescription` | Medication — appears in the Medications card |
| `availableAsInclusion` | Can be added as a plan inclusion |
| `availableAsUpsell` | Can be offered as an upsell |

A product can carry multiple flags (e.g. a supplement could be both an inclusion and an upsell).

#### Helper methods

```php
Catalogues::medications()         // requiresPrescription === true
Catalogues::inclusionProducts()   // availableAsInclusion === true
Catalogues::addonProducts()       // availableAsUpsell === true
Catalogues::productById($id)
Catalogues::variantsByProductId($productId)
Catalogues::variantById($variantId)
```

---

## API Contract

Clicking **Create Plan** produces a JSON payload. This is the proposed shape for the real API endpoint that creates a plan. Example:

```json
{
  "id": "01931c3e-...",
  "createdAt": "2026-03-07T10:00:00+00:00",
  "plan": {
    "name": "WL Starter Plan",
    "duration": { "months": 6, "autoRenew": true }
  },
  "dispatch": {
    "cycleDays": 28,
    "ordersCount": 6,
    "allowPatientRescheduling": true,
    "rescheduleDaysEarlier": 5,
    "rescheduleDaysLater": 10
  },
  "medications": [
    {
      "productId": "mounjaro",
      "variantId": "mounjaro-2.5mg",
      "qty": 1,
      "titration": { "pathId": "standard" },
      "prescription": { "renewalMonths": "3", "approvalRequiredOnDoseChange": true }
    }
  ],
  "inclusions": [...],
  "upsells": [...],
  "offers": [...]
}
```

The full schema is visible in the **Data schema** dev panel at the bottom of the page.

---

## Scope: What's Built vs What's Not

Each card section in `TreatmentPlanBuilder.html.twig` has a `{# SCOPE — ... #}` comment block directly above it using the convention:

```
✓  Built and serialised to API contract
~  Partially built — known gaps or stub data
○  Not built — needs real implementation
```

Open the template and search for `SCOPE —` to jump to any section's notes.

### Summary

| Section | Status |
|---|---|
| Plan name, duration, auto-renew, start date | ✓ Complete |
| Medications (product/variant/titration/qty/prescription) | ✓ Complete (stub catalogue) |
| Dispatch cycle + patient rescheduling | ✓ Complete |
| Clinical protocols (prescription renewal, approval flag) | ✓ Complete |
| Inclusions (product/variant/schedule/repeat-on-renewal) | ✓ Complete (stub catalogue) |
| Offers (basket value / fixed-price subscription) | ✓ Complete |
| Upsells (product/variant/schedule/pricing) | ✓ Complete (stub catalogue) |
| Real product catalogue integration | ○ Not built — replace `Catalogues.php` |
| Database persistence / Draft saving | ○ Not built — no Doctrine entities yet |
| Plan versioning / audit trail | ○ Not built |
| Clinical workflows (approval, sign-off, lab triggers) | ○ Not built |
| Payment / billing provider integration | ○ Not built |
| Patient app presentation (upsell display, rescheduling UI) | ○ Not built |

---

## Code Quality

```bash
# Run PHP CS Fixer (dry-run)
PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --dry-run --diff

# Apply fixes
PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix
```

Config: `.php-cs-fixer.php` — Symfony ruleset + short array syntax + alpha imports + single quotes.

---

## Dev Panels

Two collapsible panels at the bottom of the page (visible in the browser, not in production):

| Panel | What it shows |
|---|---|
| **Data schema** | Live JSON dump of all current LiveProp state (raw component data) |
| *(proposed)* | The Create Plan modal shows the cleaned API contract JSON with a Copy button |
