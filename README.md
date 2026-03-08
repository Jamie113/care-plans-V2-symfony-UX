# Treatment Plan Builder — Prototype

A Symfony UX Live Component prototype built so the team can interact with a treatment plan rather than read a static spec. Click through it, build a plan, hit Create Plan — the JSON output at the bottom is example API contract.

---

## What this is

It's a **prototype**, not production code. The goal was to:

- Make the treatment plan data model tangible — medications, dispatch, inclusions, upsells, offers
- Give engineers and stakeholders something to click through and give feedback on
- Produce a example JSON payload we can use as a starting point for the real API contract

Nothing persists. There's no database. The "Create Plan" button just shows you what the API call would look like.

---

## Stack

| | |
|---|---|
| Framework | Symfony 8.0 (PHP ≥ 8.4) |
| Reactivity | [Symfony UX Live Components](https://symfony.com/bundles/ux-live-component/current/index.html) |
| Templates | Twig + Tailwind CSS (CDN — no build step for CSS) |
| State | Single `TreatmentPlanBuilder` Live Component, all state in LiveProps |
| UIDs | `symfony/uid` — `Uuid::v4()->toRfc4122()` |
| Code style | PHP CS Fixer — config in `.php-cs-fixer.php` |

---

## Getting started

```bash
composer install
npm install
npm run dev
symfony serve
```

**.env.dev and .env.test are gitignored — don't commit them.** Copy `.env`, adjust locally

---

## How it works

Everything runs through a single Symfony UX Live Component (`TreatmentPlanBuilder`). Each form interaction fires an AJAX re-render back to the server — no custom JS. State lives entirely in LiveProps on the PHP class.

**Why one big component instead of smaller nested ones?**
It's a simplification that makes sense for a prototype. One component means one place to look at the data model. In production we would want to break this into sub-components per card section, communicating up via `ComponentEvent` but that's overkill for PoC.

### Files

**PHP:** `src/Twig/Components/TreatmentPlanBuilder.php`
**Root template:** `templates/components/TreatmentPlanBuilder.html.twig` (thin shell — just includes)

Each card section is its own partial in `templates/components/plan_builder/`:

| File | What's in it |
|---|---|
| `_header.html.twig` | Sticky header with Save Draft / Create Plan |
| `_card_plan_details.html.twig` | Plan name, duration, auto-renew, start date |
| `_card_medications.html.twig` | Medication rows — product, variant, titration, qty |
| `_card_dispatch.html.twig` | Dispatch cycle, order count, patient rescheduling |
| `_card_clinical.html.twig` | Prescription renewal and dose-change approval per med |
| `_card_inclusions.html.twig` | Inclusions — product, variant, schedule, repeat-on-renewal |
| `_card_offers.html.twig` | Offers — basket value / fixed-price subscription |
| `_card_upsells.html.twig` | Upsells — product, variant, schedule, pricing |
| `_summary_panel.html.twig` | Right-hand summary column |
| `_modal_create_plan.html.twig` | The Create Plan JSON modal |
| `_dev_panels.html.twig` | Data schema panel at the bottom |

Twig includes inherit the parent scope automatically so no need for `with`.

### State (LiveProps)

| Prop | Type | Notes |
|---|---|---|
| `$planName` | `string` | |
| `$durationId` | `string` | `3m`, `6m`, `12m`, or `custom` |
| `$customDurationMonths` | `int` | Only used when durationId is `custom` |
| `$autoRenew` | `bool` | |
| `$startBehaviour` | `string` | `immediately` or `future_date` |
| `$startDate` | `string` | ISO date |
| `$cycleId` | `string` | Dispatch cycle preset |
| `$customCycleDays` | `int` | Only used when cycleId is `custom` |
| `$allowPatientRescheduling` | `bool` | |
| `$rescheduleDaysEarlier` | `int` | |
| `$rescheduleDaysLater` | `int` | |
| `$medications` | `array` | |
| `$inclusions` | `array` | |
| `$offers` | `array` | |
| `$upsells` | `array` | |
| `$showPlanModal` | `bool` | Drives the Create Plan modal |

### Computed values

These are `#[ExposeInTemplate]` methods — available as variables in Twig, called as methods in PHP (not properties):

| Method | Returns |
|---|---|
| `getDuration()` | `int` months — resolves preset or custom |
| `getCycleDays()` | `int` days — resolves preset or custom |
| `getOrdersCount()` | `int` — `round((months × 30) ÷ cycleDays)` |
| `getValidation()` | `array` with `errors`, `titrationErrors`, `canCreate` |
| `getPlanJson()` | Full JSON payload string |

### LiveActions

| Action | What it does |
|---|---|
| `addMedication / removeMedication` | Add/remove a medication row |
| `setMedicationProduct` | Pick a medication, clears variant |
| `setMedicationVariant` | Pick a variant |
| `addInclusion / removeInclusion` | Add/remove an inclusion |
| `setInclusionProduct` | Pick an inclusion product, clears variant |
| `setInclusionScheduleType` | Switch between specific_orders / recurring_cycle |
| `toggleInclusionOrder` | Toggle an order number pill |
| `addUpsell / removeUpsell` | Add/remove an upsell |
| `setUpsellProduct` | Pick an upsell product, clears variant |
| `setUpsellScheduleType` | Switch between add-to-plan-orders / unique-recurring-cycle |
| `setUpsellPricingType` | Switch between catalogue / custom price |
| `addOffer / removeOffer` | Add/remove an offer |
| `createPlan` | Validate and open the JSON modal |
| `closePlanModal` | Close the modal |

---

## Product catalogue

`src/Catalogue/Catalogues.php` is a static stub — hardcoded products and variants.

Each product has three flags:

| Flag | What it controls |
|---|---|
| `requiresPrescription` | Shows up in the Medications card |
| `availableAsInclusion` | Can be added as an inclusion |
| `availableAsUpsell` | Can be added as an upsell |

A product can have more than one flag — e.g. a supplement that's both an inclusion and an upsell.

```php
Catalogues::medications()
Catalogues::inclusionProducts()
Catalogues::addonProducts()
Catalogues::productById($id)
Catalogues::variantsByProductId($productId)
Catalogues::variantById($variantId)
```

---

## API contract

Hitting Create Plan generates something like this:

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

The live version (reflecting whatever you've built in the UI) is in the Data schema panel at the bottom of the page.

---

## What's built and what isn't

Each partial has a `{# SCOPE — ... #}` block at the top. Search for `SCOPE —` in `templates/components/plan_builder/` to find the notes for any section. Convention is:

```
✓  Built and in the API contract
~  Partially built — gaps noted
○  Not built
```

Quick summary:

| | |
|---|---|
| Plan name, duration, auto-renew, start date | ✓ |
| Medications — product, variant, titration, qty, prescription | ✓ stub catalogue |
| Dispatch cycle + patient rescheduling | ✓ |
| Clinical protocols — renewal period, dose-change approval | ✓ |
| Inclusions — product, variant, schedule, repeat-on-renewal | ✓ stub catalogue |
| Offers — basket value / fixed-price subscription | ✓ |
| Upsells — product, variant, schedule, pricing | ✓ stub catalogue |
| Real product catalogue | ○ replace `Catalogues.php` |
| Database / draft saving | ○ no Doctrine yet |
| Plan versioning | ○ |
| Clinical approval workflows | ○ |
| Payment / billing | ○ |

---

## Linting

```bash
# PHP
PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix --dry-run --diff
PHP_CS_FIXER_IGNORE_ENV=1 vendor/bin/php-cs-fixer fix

# Twig
php bin/console lint:twig templates/
```

---

## Dev panel

There's a collapsible **Data schema** panel at the bottom of the page — live JSON dump of all current component state. Useful for checking what would actually get sent to the API.
