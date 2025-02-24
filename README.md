# Multi-Tenancy Event Management System

## Overview
This project is a multi-tenant event management system built with Laravel. It allows a super admin to manage tenants and subscriptions, while tenants can manage their events and users can book events.

## Main Domain Functionalities
- **Super Admin Login**
- **Create Subscription Plan**
- **Add Payment Method Keys**
- **View Tenants**

## Tenant Registration Process
When a tenant registers on the main domain:
1. Registers on the main domain.
2. A separate domain is created for the tenant.
3. Tenant's record is stored in the tenant database.
4. Tenant subscribes to a package.
5. Tenant adds payment method keys.
6. Tenant can now create events.

## Standard User Registration on Tenant Subdomain
- View events of that tenant.
- Book events by paying the price.

## Multi-Tenancy Explanation
Multi-tenancy is an architecture in which multiple tenants (organizations or users) share the same application instance but have separate databases or schema configurations. Our system uses the **stancl/tenancy** package to achieve this.

## How Multi-Tenancy Works in Our System
- The super admin manages tenants from the main domain.
- When a tenant registers, a separate domain is created for them.
- Each tenant has its own database to keep data isolated.
- Tenants manage their own events and users.
- Standard users can register and book events on a tenant's subdomain.

## System Requirements
- **PHP Version:** 8.1+
- **Node.js Version:** 18+
- **Composer:** Latest stable version

## Required Packages
The following packages are used in this project:
1. **Laravel Framework** - `laravel/framework ^10.10`
2. **Multi-Tenancy** - `stancl/tenancy ^3.8`
3. **Authentication** - `laravel/sanctum ^3.3`
4. **Payments** - `stripe/stripe-php ^16.5`
5. **HTTP Client** - `guzzlehttp/guzzle ^7.2`
6. **Laravel Breeze** - `laravel/breeze ^1.29` (for authentication scaffolding)

## Installation
Follow these steps to set up the project:
1. Clone the repository:
   ```sh
   git clone https://github.com/its-Hamza-Baig/multi-tenant-event-management-system.git
   ```
2. Navigate to the project directory:
   ```sh
   cd multi-tenant-event-management-system
   ```
3. Install dependencies:
   ```sh
   composer install
   npm install && npm run dev
   ```
4. Set up the `.env` file:
   ```sh
   cp .env.example .env
   ```
   - Configure database and tenancy settings.
5. Run migrations:
   ```sh
   php artisan migrate --seed
   ```
6. Start the development server:
   ```sh
   php artisan serve
   ```

7. Add these lines and add the main database connection in it:
   ```sh
   DB_MAIN_CONNECTION=mysql
   DB_MAIN_HOST=127.0.0.1
   DB_MAIN_PORT=3306
   DB_MAIN_DATABASE=multi_tenant_event_management_system
   DB_MAIN_USERNAME=root
   DB_MAIN_PASSWORD=
   ```

## Flow Chart Diagram
![Image](https://github.com/user-attachments/assets/491c70b4-4b87-41e4-8f6b-0a72ba396993)

## ERD Diagram
![Image](https://github.com/user-attachments/assets/b3c2f950-14cb-4907-82fe-ba8c6d4bd2d9)


