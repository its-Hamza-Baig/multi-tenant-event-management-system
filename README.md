# Multi-Tenant Event Management System

This is a **Multi-Tenant Event Management System** built using **Laravel 10**. The project includes **Laravel Breeze** for authentication and supports multi-tenancy to manage events across different organizations. The project is built using **PHP 8.1**.

## Features
- Multi-tenancy support for managing multiple organizations
- User authentication with **Laravel Breeze**
- Event creation, management, and tracking  

## Requirements

Make sure you have the following installed before proceeding:

- **PHP 8.1** or later
- **Composer** (PHP dependency manager)
- **Node.js & NPM ^v 18** (for frontend assets)
- **MySQL** or any other supported database

## Installation & Setup

Follow these steps to set up the project on your local machine:

### 1. Clone the Repository
```bash
git clone https://github.com/its-Hamza-Baig/multi-tenant-event-management-system.git
cd multi-tenant-event-management-system
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Copy Environment File
```bash
cp .env.example .env
```


### 4. Configure Database
Edit the `.env` file and update the following:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Run Migrations
```bash
php artisan migrate
```
 
Select **Blade** when prompted for the stack.

### 6. Install NPM Dependencies & Build Frontend
```bash
npm install
npm run dev
```

### 7. Seed Default Tenant & Users
```bash
php artisan db:seed
```

### 8. Serve the Application
```bash
php artisan serve
```
Visit **http://127.0.0.1:8000** in your browser to view the project.
 

## Authentication
Laravel Breeze provides authentication out of the box. You can access the following routes:

- **Login**: `/login`
- **Register**: `/register`
- **Dashboard (after login)**: `/dashboard`

## Additional Commands

### Running Tests
```bash
php artisan test
```
 

## License
This project is open-source and available under the [MIT License](LICENSE).

---

### 🎉 You’re all set!
Now you can start building your Multi-Tenant Event Management System with Breeze authentication. If you face any issues, check the Laravel documentation or open an issue in this repository.

