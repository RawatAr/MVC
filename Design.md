# Design Document — BloodLink: Blood Donation & Finder Application

> **Course:** INT221 — MVC Programming (Laravel)
> **Session:** 2025–26
> **Scope:** All design decisions are strictly bounded by the INT221 syllabus (Units I–VI).

---

## 1. Project Overview

BloodLink is a web application built with the Laravel MVC framework that modernizes blood donation and recipient matching. It maintains a real-time database of blood banks and available blood units in a locality, allows individuals to raise urgent blood requests, and helps users locate nearby hospitals and blood bank events.

---

## 2. Course Outcome Mapping

| CO | Outcome | Coverage in BloodLink |
|----|---------|----------------------|
| CO1 | Recall Laravel features and installation | Project setup using Composer, Artisan scaffolding, directory structure |
| CO2 | Apply routing, handle HTTP requests, customize responses | All application routes, request handling, JSON and redirect responses |
| CO3 | Develop controllers, Blade templates, advanced routing | DonorController, BloodBankController, Blade views with inheritance |
| CO4 | Manage cookies, emails, sessions | Donor session login, email notifications for blood requests, cookies |
| CO5 | Design forms and execute form validation | Registration, blood request, and blood bank listing forms |
| CO6 | Employ databases for data handling | Eloquent ORM for donors, blood banks, and requests; Query Builder for reports |

---

## 3. Application Architecture

BloodLink follows the **MVC (Model–View–Controller)** architectural pattern as defined in the Laravel framework.

```
BloodLink/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DonorController.php
│   │   │   ├── BloodBankController.php
│   │   │   ├── BloodRequestController.php
│   │   │   └── EventController.php
│   │   └── Middleware/
│   │       └── AuthSessionMiddleware.php
│   └── Models/
│       ├── Donor.php
│       ├── BloodBank.php
│       ├── BloodRequest.php
│       └── Event.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php          ← Master layout (template inheritance)
│       ├── donor/
│       │   ├── register.blade.php
│       │   └── dashboard.blade.php
│       ├── blood-bank/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── request/
│       │   ├── create.blade.php
│       │   └── track.blade.php
│       └── events/
│           └── index.blade.php
├── routes/
│   └── web.php
└── database/
    └── migrations/
```

---

## 4. Module Breakdown

### 4.1 Module 1 — Application Setup (Unit I)

- Laravel project initialized via Composer (`composer create-project laravel/laravel bloodlink`).
- Artisan commands used for generating controllers, models, and migrations.
- Directory and application structure follow Laravel conventions as covered in the syllabus.

### 4.2 Module 2 — Routing & Responses (Unit II)

**Routes defined in `routes/web.php`:**

| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | `/` | `HomeController@index` | Landing page |
| GET | `/blood-banks` | `BloodBankController@index` | List all blood banks |
| GET | `/blood-banks/{id}` | `BloodBankController@show` | Blood bank detail with unit availability |
| GET | `/request/create` | `BloodRequestController@create` | Blood request form |
| POST | `/request` | `BloodRequestController@store` | Submit blood request |
| GET | `/request/{id}/track` | `BloodRequestController@track` | Track request status |
| GET | `/donor/register` | `DonorController@create` | Donor registration form |
| POST | `/donor/register` | `DonorController@store` | Save donor |
| GET | `/donor/dashboard` | `DonorController@dashboard` | Donor dashboard (session-protected) |
| GET | `/events` | `EventController@index` | List blood bank events |
| POST | `/donor/login` | `DonorController@login` | Authenticate and start session |
| GET | `/donor/logout` | `DonorController@logout` | Destroy session |

**Response types used:**
- Blade view responses for all HTML pages.
- JSON responses for blood unit availability (consumed by the locality map section).
- Laravel Redirections (with named routes) after form submissions.
- Redirect to named routes (`route('donor.dashboard')`) after login.

### 4.3 Module 3 — Controllers, Blade & Advanced Routing (Unit III)

**Controllers:**

- `DonorController` — Handles registration, login/logout, and dashboard.
- `BloodBankController` — Lists blood banks and shows per-bank blood unit details.
- `BloodRequestController` — Creates and tracks blood requests.
- `EventController` — Lists events organized by blood banks.

**Middleware:**

- `AuthSessionMiddleware` — Protects the donor dashboard by checking for an active session; redirects unauthenticated users to the login page.

**Blade Templates:**

- `layouts/app.blade.php` — Master layout using `@yield` and `@section` directives; demonstrates template inheritance as per the syllabus.
- All child views extend the master layout via `@extends('layouts.app')`.
- `@include` used for reusable partials such as the navigation bar and alert messages.

**Advanced Routing:**

- Named routes used throughout (e.g., `route('blood-banks.show', $id)`).
- Route groups applied with the `auth.session` middleware prefix for all donor-authenticated routes.
- Parameter constraints applied on `{id}` route parameters (`->whereNumber('id')`).
- Route prefixing used for the `/donor` group.

### 4.4 Module 4 — Request Data, Emails & Sessions (Unit IV)

**Request Data Handling:**

- `Request` facade used in all controller store/update methods.
- Old input preserved on validation failure using `withInput()`.
- File upload handling for donor profile photo (uploaded files retrieved via `$request->file()`).
- Cookies used to remember the donor's preferred locality for blood bank filtering.

**Email Notifications (Nodemailer equivalent in Laravel — `Mail` facade):**

- When a blood request is submitted with urgent priority, an email notification is sent to all registered donors with matching blood group in the locality.
- `Sending Emails` is implemented using Laravel's `Mail::send()` with a Blade email template.

**Sessions:**

- Donor login stores session data: `session(['donor_id' => $donor->id, 'donor_name' => $donor->name])`.
- Session data accessed in controllers and Blade views to personalize the dashboard.
- Logout destroys the session: `Session::flush()` / `$request->session()->invalidate()`.

**Localization:**

- Laravel localization used to support English language strings in `resources/lang/en/`.
- Validation error messages and UI strings loaded via the `__('messages.key')` helper.

### 4.5 Module 5 — Form Validation (Unit V)

**Forms and validation rules:**

| Form | Fields | Validation Rules |
|------|--------|-----------------|
| Donor Registration | name, email, phone, blood_group, city | required, email, min:10 digits, in:[A+,A-,B+,B-,O+,O-,AB+,AB-] |
| Blood Request | requester_name, blood_group, units_needed, hospital, city, urgency | required, integer min:1, in:urgent/normal |
| Blood Bank Listing | bank_name, address, city, contact, blood_units (JSON) | required, string, valid JSON |
| Donor Login | email, password | required, email |

- CSRF field (`@csrf`) included in every form per the syllabus.
- Method field (`@method('PUT')`) used for update operations.
- Custom validation rules implemented for blood group format verification.
- Repopulation of forms on failure using `old('field_name')` in Blade templates.
- Error messages displayed using `$errors->first('field')` in views.

### 4.6 Module 6 — Database (Unit VI)

**Models:**

| Model | Table | Key Columns |
|-------|-------|-------------|
| `Donor` | `donors` | id, name, email, phone, blood_group, city, is_available |
| `BloodBank` | `blood_banks` | id, name, address, city, contact, verified |
| `BloodStock` | `blood_stocks` | id, blood_bank_id, blood_group, units_available, updated_at |
| `BloodRequest` | `blood_requests` | id, requester_name, blood_group, units_needed, hospital, city, urgency, status |
| `Event` | `events` | id, blood_bank_id, title, description, event_date, location |

**Migrations:**

- All tables created via `php artisan make:migration` as per the practicals list.
- Foreign key constraints set between `blood_stocks` and `blood_banks`, and between `events` and `blood_banks`.

**Eloquent ORM:**

- `hasMany` / `belongsTo` relationships defined between `BloodBank` and `BloodStock`, and between `BloodBank` and `Event`.
- Eloquent used for all CRUD operations on donors, blood requests, and events.
- `BloodStock::where('blood_group', $group)->where('units_available', '>', 0)->get()` used to find available stock.

**Query Builder:**

- Used for locality-based blood bank search: `DB::table('blood_banks')->where('city', $city)->get()`.
- Seeding used to pre-populate blood groups, sample blood banks, and test donors.

---

## 5. Page-Level Design

### 5.1 Landing Page (`/`)
- Hero section with tagline.
- Quick search bar: blood group + city → redirects to `/blood-banks?city=X&group=Y`.
- Navigation: Home | Find Blood | Request Blood | Donate | Events | Login.

### 5.2 Blood Bank Listing (`/blood-banks`)
- Tabular list of verified blood banks in the searched locality.
- Each row shows: Bank Name, City, Available Groups (colored tags), Contact.
- Links to the detailed show page.

### 5.3 Blood Bank Detail (`/blood-banks/{id}`)
- Bank profile: name, address, contact.
- Blood unit availability table: Group | Units Available | Last Updated.
- JSON response endpoint used internally to refresh unit counts.

### 5.4 Blood Request Form (`/request/create`)
- CSRF-protected form with fields: requester name, blood group, units needed, hospital name, city, urgency level.
- On submission: stores request, sends email to matching donors (if urgent), redirects to tracking page.

### 5.5 Blood Request Tracking (`/request/{id}/track`)
- Displays current status of the submitted request.
- Status values: Pending | Matched | Fulfilled.

### 5.6 Donor Registration & Dashboard
- Registration form with validation.
- On login, session is created; dashboard shows the donor's profile and nearby active requests matching their blood group.
- Logout destroys session and redirects to home.

### 5.7 Events Page (`/events`)
- Lists upcoming blood donation camps and drives organized by blood banks.
- Each event shows: title, hosting blood bank, date, location.

---

## 6. Data Flow

```
User fills Blood Request Form
        ↓
POST /request  →  BloodRequestController@store
        ↓
Form Validation (Unit V)
        ↓ (pass)
Eloquent: BloodRequest::create([...])  (Unit VI)
        ↓
Mail::send() → Email to matching donors  (Unit IV)
        ↓
Redirect to /request/{id}/track  (Unit II — Named Route Redirect)
        ↓
BloodRequestController@track → Blade view  (Unit III)
```

---

## 7. Practicals Coverage

| Practical | Where Implemented |
|-----------|------------------|
| Installation of Laravel and Composer | Project initialization |
| Implement sharing of data with views | `BloodBankController` passes `$banks` to `index.blade.php` via `compact()` |
| Use route parameters and parameter constraints | `/blood-banks/{id}` with `->whereNumber('id')` |
| Implement redirections using routes and controllers | Post-registration and post-login redirects using named routes |
| Create and register middlewares | `AuthSessionMiddleware` registered for `/donor/dashboard` |
| Create Blade templates and template inheritance | `layouts/app.blade.php` extended by all child views |
| Use restful resource controllers for CRUD | `BloodRequestController` and `BloodBankController` as resource controllers |
| Work with advanced routing and URL methods | Route groups, prefixing, named routes, URL generation helpers |

---

## 8. Out of Scope

The following are explicitly excluded to remain within the INT221 syllabus boundary:

- Real-time geo-tracking / GPS map integration (requires frontend JavaScript frameworks beyond the syllabus).
- Live push notifications (WebSockets / broadcasting).
- Payment gateway integration.
- Mobile application layer.
- REST API authentication (JWT / OAuth) — only session-based auth is used.
- Any frontend JavaScript framework (React, Vue, etc.).
