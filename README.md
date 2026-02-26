Laravel Admin Blog

A full-featured blog with an admin panel built on Laravel, demonstrating engineering-level architecture, CQRS-lite, immutable Commands, Handlers, DTOs, Policies, and strict role management with Enums.

Admin panel: AdminLTE 3 (standard page reload forms).
Public site: AJAX endpoints for post creation/update with json middleware.

📌 Project Goal

Showcase production-ready Laravel architecture with clean separation of concerns.

Demonstrate admin panel functionality, role-based authorization, custom pagination, DTOs for read-layer, and strict Commands/Handlers for writes.

Maintain readable, maintainable, and explicit code without magic or hidden defaults.

⚙️ Stack & Technologies

Back-end: Laravel (MVC as infrastructure, Handlers, Commands, DTOs, CQRS-lite, Policies)

Admin Frontend: AdminLTE 3, Blade, native JS + jQuery

Database: MySQL/PostgreSQL via Eloquent ORM, migrations

Authorization: Policies + Gates, role-based access, admin-only middleware

Middleware: json (public AJAX endpoints), admin (admin panel access)

Frontend components: custom pagination (no Tailwind), forms, AdminLTE styling

🏗 Architecture & Approach

CQRS-lite: separation of write (Commands/Handlers) and read (Queries/DTOs) layers.

Immutable Commands: readonly/final, no default values, minimal nullable types.

DTOs: presentation-only, prevent models from leaking into views.

Policies: enforce role-based access and edge-cases (update, delete, changeRole, assignRole).

Value Objects (VOs): e.g., Slug for strict handling of post identifiers.

Enums: RoleSlug for controlled role assignments.

Middleware separation: AJAX for public endpoints; standard forms for admin.

Frontend: custom components with JS/jQuery, AdminLTE styling, AJAX where appropriate.

🛠 Example: Update User Flow
Command
final readonly class UpdateUserCommand
{
public function __construct(
public int $userId,
public string $name,
public string $email,
public ?array $roles,
) {}
}
Handler
class UpdateUserHandler
{
public function handle(UpdateUserCommand $command): UserViewDTO
{
// Explicit query
$user = User::query()
->where('id', $command->userId)
->firstOrFail();

        $user->update([
            'name' => $command->name,
            'email' => $command->email,
        ]);

        // Roles updated separately through Policy/Service
        if ($command->roles !== null) {
            $user->syncRoles($command->roles);
        }

        return new UserViewDTO($user);
    }
}
DTO
final readonly class UserViewDTO
{
public function __construct(
public int $id,
public string $name,
public string $email,
public array $roles,
) {}
}

Demonstrates engineering-style CQRS-lite: immutable Commands, explicit queries, separation of concerns, and DTOs for output only.

📄 Policies

UserPolicy enforces edge-cases and role hierarchy:

Users cannot change their own roles

Admin can manage everyone except other admins

Editor can manage only normal users, not admins or editors

Methods include: update, delete, changeRole, allowedRoles, assignRole

Applied via Gate / can() in controllers and Blade templates

🔹 Read Layer & Queries

Queries (UserListQuery, PostListQuery) are read-only

Return DTOs for presentation layer

Separation ensures no side-effects during reads

📌 Project Features

Pagination: custom component, independent of Tailwind

Enums: RoleSlug for strict role assignments

Value Objects: Slug VO for consistent post identifiers

AJAX: public post endpoints with json middleware

Middleware: admin-only for admin panel

Frontend: AdminLTE 3, custom forms, native JS + jQuery

🚀 Local Setup
git clone https://github.com/nykoliuk-dev/laravel-admin-blog.git
cd laravel-admin-blog
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
🧪 Testing

Unit and integration tests planned for Laravel project.

Handlers, Policies, Queries will be covered once tests are added:

php artisan test
👨‍💻 Skills & Approach

Explicit, readable code; no hidden magic, no default nullable values.

CQRS-lite: immutable Commands, Handlers, Queries, DTOs.

Policies enforce role-based edge-cases.

VO + Enum demonstrate strict type control and DDD discipline.

Middleware enforces route separation (admin vs public AJAX).

Custom frontend components: AdminLTE 3, JS/jQuery, custom pagination.

🔗 Contacts

LinkedIn

GitHub
