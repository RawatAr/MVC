# Tech Stack — BloodLink: Blood Donation & Finder Application

> **Course:** INT221 — MVC Programming (Laravel)
> **Session:** 2025–26
> **Constraint:** Every technology listed here maps directly to a topic covered in the INT221 syllabus. No tool or library is included beyond the defined scope.

---

## 1. Core Framework

| Technology | Version | Role | Syllabus Reference |
|------------|---------|------|--------------------|
| **Laravel** | Latest stable (as per installation practical) | Full-stack MVC web framework — handles routing, controllers, views, ORM, mail, and sessions | Unit I — Overview of Laravel framework and its features |
| **PHP** | 8.x (Laravel requirement) | Server-side language in which Laravel is written | Unit I — Getting started with MVC Laravel framework |

---

## 2. Package Manager & CLI Tools

| Tool | Role | Syllabus Reference |
|------|------|--------------------|
| **Composer** | PHP dependency manager; used to install and manage Laravel and its packages | Unit I — Introduction to Composer, Latest Composer installation |
| **Artisan CLI** | Laravel's built-in command-line tool; used to generate controllers, models, migrations, and run seeders | Unit I — Artisan |

---

## 3. Routing & HTTP Layer

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Laravel Router** (`routes/web.php`) | Defines all application routes: basic, parameterized, named, grouped, and prefixed routes | Unit II — Basic Routing, Routing Parameters; Unit III — Advanced Routing, Named Routes, Secure Routes, Route Groups, Route Prefixing, Domain Routing |
| **Laravel Request** (`Illuminate\Http\Request`) | Handles incoming HTTP request data, old input, and uploaded files | Unit IV — Request Data-Retrieval, Old Input, Uploaded Files |
| **Laravel Response** | Sends Blade view responses, JSON responses, and redirections | Unit II — Laravel Response, Attaching Headers, Attaching Cookies, JSON Response, Laravel Redirections, Redirecting to Named Routes, Redirecting to Controller Actions |

---

## 4. MVC Components

### 4.1 Controllers

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Basic Controllers** | Handle HTTP request logic and return responses or views | Unit III — Basic Controllers, Creating Controllers, Controller Routing |
| **Restful Resource Controllers** | Provide standard CRUD operations (index, create, store, show, edit, update, destroy) | Unit III — Restful Resource Controllers; Practical — Use restful resource controllers to perform CRUD operations |
| **Controller Middleware** | Attach middleware to controller methods for access control | Unit III — Controller Middleware |
| **Controller Structures** | Organized controller files following Laravel conventions | Unit III — Controller Structures |

### 4.2 Views — Blade Templating Engine

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Blade Templates** | Laravel's templating engine; used for all HTML views in the application | Unit III — Blade — Creating Templates |
| **Template Inheritance** (`@extends`, `@yield`, `@section`) | Master layout (`layouts/app.blade.php`) extended by all child views | Unit III — Templates Inheritance; Practical — Create blade templates and template inheritance |
| **PHP Output in Blade** (`{{ }}`, `{!! !!}`) | Rendering dynamic data safely in views | Unit III — PHP Output |
| **Passing Data to Views** (`compact()`, `with()`) | Controllers pass model data to Blade views | Unit II — Passing Data to Views, Sharing Data with all Views |

### 4.3 Middleware

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Custom Middleware** (`AuthSessionMiddleware`) | Protects authenticated routes by verifying active donor session | Unit III — Controller Middleware; Practical — Create and register middlewares in Laravel |

---

## 5. URL Generation

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Named Routes** (`route('name')`) | Generate URLs by route name across controllers and Blade views | Unit III — URL Generation — The Current URL, Named Routes |
| **Framework URLs** (`url()`) | Generate absolute URLs to application paths | Unit III — Generating Framework URLs |
| **Asset URLs** (`asset()`) | Reference CSS, JS, and image assets from the `public/` directory | Unit III — Asset URLs |
| **Generation Shortcuts** (`redirect()->route()`) | Shortcut helpers for redirects and URL generation inside controllers | Unit III — Generation Shortcuts |

---

## 6. Request Data, Cookies, Email & Sessions

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Old Input** (`old()`) | Re-populates form fields after a failed validation redirect | Unit IV — Old Input |
| **Uploaded Files** (`$request->file()`) | Handles donor profile photo upload | Unit IV — Uploaded Files |
| **Cookies** | Remembers donor's preferred locality across visits | Unit IV — Cookies |
| **Laravel Mail** (`Mail::send()`) | Sends email notifications to matching blood group donors on urgent requests | Unit IV — Sending Emails |
| **Laravel Session** | Stores donor authentication state; reads/writes/deletes session data | Unit IV — Laravel Session — Accessing Session Data, Storing Session Data, Deleting Session Data |

---

## 7. Localization

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Laravel Localization** (`resources/lang/`) | Stores all UI strings and validation messages in language files; accessed via `__()` helper | Unit IV — Laravel Localization and Examples |

---

## 8. Form Validation

| Component | Role | Syllabus Reference |
|-----------|--------|--------------------|
| **CSRF Field** (`@csrf`) | Protects all POST forms against Cross-Site Request Forgery | Unit V — CSRF field |
| **Method Field** (`@method`) | Allows HTML forms to send PUT/PATCH/DELETE requests | Unit V — Method field |
| **Laravel Form Validation** (`$request->validate()`) | Server-side validation of all user inputs | Unit V — Laravel Form validation |
| **Validation Rules** | Built-in rules: `required`, `email`, `in`, `integer`, `min`, `max`, `string` | Unit V — Validation Rules |
| **Error Messages** (`$errors`) | Displays per-field validation errors in Blade views | Unit V — Error Messages |
| **Custom Validation Rules** | Blood group format validator implemented as a custom rule class | Unit V — Custom Validation Rules |
| **Repopulating Forms** (`old('field')`) | Fills form fields with previously entered values after validation failure | Unit V — Repopulating Forms |

---

## 9. Database Layer

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **MySQL** | Relational database storing donors, blood banks, blood stock, requests, and events | Unit VI — Getting started with databases |
| **Laravel Migrations** | Version-controlled schema definitions; applied via `php artisan migrate` | Unit VI — Migrations |
| **Eloquent ORM** | Object-relational mapper used for all primary CRUD operations and model relationships | Unit VI — CRUD using Eloquent ORM (Object Relational Mapper) |
| **Query Builder** (`DB::table()`) | Used for locality-based blood bank search queries requiring more flexibility | Unit VI — CRUD using Query Builder |
| **Database Seeding** | Pre-populates blood groups, sample banks, and test donor records | Unit VI — Seeding |
| **Model Creation** (`php artisan make:model`) | Generates Eloquent model classes for each database entity | Unit VI — Model creation |
| **MongoDB with Laravel** | Optional secondary data store for blood stock units (high-frequency read/write); integrated via Laravel's MongoDB package | Unit VI — Using MongoDB with Laravel |

---

## 10. REST API

| Component | Role | Syllabus Reference |
|-----------|------|--------------------|
| **Laravel REST APIs** | JSON endpoints exposing blood stock availability per blood bank, consumed internally by the locality search view | Unit VI — Implementing Rest APIs |

---

## 11. Development Environment

| Tool | Role | Syllabus Reference |
|------|------|--------------------|
| **Composer** | Install Laravel and all PHP dependencies | Unit I — Introduction to Composer, Latest Composer installation |
| **Laravel Artisan** | Scaffold, migrate, seed, and serve the application locally (`php artisan serve`) | Unit I — Artisan |
| **Command Prompt / Terminal** | Used for all Composer and Artisan commands | Practical — Installation of Laravel and Composer using command prompt |

---

## 12. What is NOT Used (and Why)

The following technologies are intentionally excluded to stay within the INT221 syllabus boundary:

| Excluded Technology | Reason |
|--------------------|--------|
| JavaScript frameworks (React, Vue, Alpine) | Not covered in INT221 |
| Real-time geo-tracking / Maps SDK | Requires frontend JS beyond syllabus scope |
| WebSockets / Laravel Echo / Pusher | Not covered in INT221 |
| JWT / OAuth authentication | Only session-based authentication is in scope (Unit IV) |
| Docker / containerization | Not covered in INT221 |
| CI/CD pipelines | Not covered in INT221 |
| Tailwind CSS / Bootstrap | No frontend build tools specified in syllabus; plain CSS used |

---

## Summary Table

| Layer | Technology | Syllabus Unit |
|-------|-----------|--------------|
| Language | PHP 8.x | I |
| Framework | Laravel (latest) | I–VI |
| Dependency Manager | Composer | I |
| CLI Scaffolding | Artisan | I |
| Routing | Laravel Router | II, III |
| HTTP | Laravel Request / Response | II, IV |
| Views | Blade Templating Engine | II, III |
| Middleware | Custom AuthSessionMiddleware | III |
| URL Helpers | `route()`, `url()`, `asset()` | III |
| Sessions | Laravel Session | IV |
| Email | Laravel Mail | IV |
| Cookies | Laravel Cookie | IV |
| Localization | Laravel Lang | IV |
| Validation | Laravel Validator | V |
| ORM | Eloquent | VI |
| Query Builder | Laravel DB Facade | VI |
| Relational Database | MySQL | VI |
| Document Store | MongoDB (optional) | VI |
| REST API | Laravel JSON Routes | VI |
