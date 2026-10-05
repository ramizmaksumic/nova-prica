# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Website and table-reservation system for "Nova Priča", a weekend nightclub / gastro pub in Mostar. Laravel 12 + Livewire 3 (admin panel, using `livewire-ui/modal` for modals) + Blade/Tailwind/Alpine (public site). UI text, comments and user-facing messages are in Bosnian; keep new ones in Bosnian.

Production is cPanel shared hosting (MySQL, no supervisor): the queue and scheduler run from cron (`schedule:run` every minute plus a cron-driven queue worker). The local `.env` is not the production config.

## Commands

```bash
composer install                 # vendor/ may be installed --no-dev; dev deps are needed for tests
npm run build                    # Vite build into public/build (gitignored, uploaded manually on deploy)
composer dev                     # serve + queue:listen + vite together

php vendor/bin/pest                                   # full suite (SQLite in-memory, see phpunit.xml)
php vendor/bin/pest tests/Feature/ReservationTest.php # one file
php vendor/bin/pest --filter="table cannot be reserved twice"   # one test
DB_CONNECTION=mysql DB_DATABASE=nova_prica_test php vendor/bin/pest   # against MySQL, like production

php artisan events:send-reminders   # reminder mails for today's events (scheduled daily 09:00)
```

Run `composer dump-autoload -o` after deleting or renaming classes. The optimized classmap otherwise breaks `view:cache` and `optimize`. `php artisan route:cache` must keep working, so route names must be unique.

Migrations must run on both MySQL/MariaDB (production) and SQLite (tests). Use `Schema::hasIndex` and similar portable APIs, not raw `SHOW INDEX`. Branch on `DB::getDriverName()` where syntax differs (see the `active_slot` generated column).

## Reservation domain (spans several files)

- A reservation books one **table** for one **event** for the whole night. Statuses are defined in `Reservation::STATUS_*`. `pending` and `active` are *blocking* (`Reservation::BLOCKING_STATUSES`, `scopeBlocking()`); `cancelled` frees the table. Users cancel by setting the status. Only admins hard-delete.
- **Double booking is prevented by the database.** `reservations.active_slot` is a generated column (1 when blocking, NULL when cancelled) with a unique index `(event_id, table_id, active_slot)`. `App\Services\ReservationService` does friendly pre-checks and converts `UniqueConstraintViolationException` into a validation error. All reservation creation and admin updates go through this service (user controller and admin Livewire components alike).
- User rules, enforced in the service: event must be bookable (`Event::acceptsReservations()`: active, not ended, no Entrio `link`), number of people within the table's `min_capacity`–`max_capacity`, and at most `MAX_PER_USER_PER_EVENT` blocking reservations. The admin path (`byAdmin: true`) skips these but never the "table free" check.
- **Event time model:** `events.date` is often stored as date-only (00:00). An event counts as running until `CLOSING_HOUR_NEXT_DAY` (06:00) on the following day (`Event::endsAt()`, `hasEnded()`, `scopeNotEnded()`, `scopeUpcoming()`). Use these helpers instead of comparing `date` to `now()` directly. App timezone is `Europe/Sarajevo`.
- Admin-entered (phone) reservations have `user_id = NULL` and use `guest_name`/`guest_phone`. In views and PDFs use `guestDisplayName()`, `contactEmail()` and `contactPhone()`, never `$reservation->user->...`.
- Ownership checks for user edit and cancel are in `App\Policies\ReservationPolicy` (`Gate::authorize`).
- Table occupancy is always per event, computed from `reservations`. There is no per-table "reserved" flag. `EventController::detail` computes reserved and pending table IDs once and passes them to `x-table-layout-component` → `svg/mapa-stolova.blade.php`. The SVG map's `data-table-id` attributes must match `tables.id`.

## Admin panel

- Admin routes use `auth` + `role:admin` (`RoleMiddleware`, compares `users.role`). Every admin Livewire component (`app/Livewire/Admin/*`, `AdminDashboard`) must `use RequiresAdmin`. That trait re-checks the role on every Livewire request, because modal components are reachable without going through the route.
- `role` is deliberately **not** in `User::$fillable`. Set it with `forceFill` or a direct assignment.
- Pages are full-page Livewire components that `->extends('admin.dashboard')->section('content')`. Modals extend `ModalComponent`, are opened with `$dispatch('openModal', {component: 'admin.xyz', arguments: {...}})`, and refresh lists via events mapped to `'$refresh'`.

## Mail & queue

All mailables implement `ShouldQueue` and use markdown templates in `resources/views/emails`. The admin copy goes to `config('mail.admin_email')` (`ADMIN_EMAIL`). `ReservationDeleteMail` stores plain values instead of the model, because the reservation is deleted before the job runs.

## Front end / SEO

- Alpine comes only from Livewire (`@livewireScripts` in the layouts). Do not import or start Alpine in `resources/js/app.js` and do not add a CDN copy.
- `resources/views/partials/seo.blade.php` (included by both layouts) builds title, description, canonical and OG tags from the sections `title`, `meta_description`, `og_image`, `og_type` and `noindex`. JSON-LD goes in `@push('structured_data')`. New public pages should set `title` and `meta_description`; private pages should set `noindex`.
- `RedirectToCanonicalHost` (prepended to the `web` group) 301-redirects `www.` to the `APP_URL` host in production. `/sitemap.xml` is generated by `SitemapController`.
- Breeze-style views using `<x-guest-layout>` still exist for auth pages. `layouts/app.blade.php` uses `@yield('content')`, so public and user pages must use `@extends('layouts.app')`, not `<x-app-layout>`.
