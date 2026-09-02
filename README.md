# POS / Cashier Management System

A full-featured Point-of-Sale system with role-based access, inventory synchronization, and a customer loyalty points program. Built as a competency exam (Uji Kompetensi) capstone project for BNSP Junior Programmer certification.

## About

This isn't a basic CRUD demo. It's a transactional system where sales, inventory, and customer loyalty points are all connected. Deleting a sale reverses stock changes. Selling a product deducts stock automatically. Members earn and redeem points as part of the payment flow itself, not as a bolt-on feature.

## Built with

- Laravel / PHP
- Blade
- Eloquent ORM
- MySQL
- Bootstrap
- Chart.js
- Laravel Excel (Maatwebsite)
- DomPDF
- Google reCAPTCHA
- Carbon

## Roles

Two roles with genuinely separate access, enforced at the middleware level (`cekRole:admin`, `cekRole:cashier`) rather than hidden buttons on the frontend.

- **Admin**: full system access, analytics, user and product management
- **Cashier**: POS access, sales limited to their own transactions

## Core Features

### Authentication & Authorization
- Login with email + password, protected by Google reCAPTCHA
- Role-based middleware (`isLogin`, `cekRole:admin`, `cekRole:cashier`)

### User Management (Admin)
- Full user CRUD, including role and password changes
- Duplicate email validation, password hashing via Laravel `Hash`
- Business rule: users can't be deleted if they have existing sales records

### Product & Inventory
- Full product CRUD with price, stock, and image management
- Image validation (format and max 2MB size)
- **Stock is live-synced with transactions**, not a static count:
  - New sale: stock decreases automatically
  - Deleted sale: stock is restored automatically

### Sales / POS Transactions
- Cashier flow: select product, set quantity, calculate total, choose member or non-member, take payment, calculate change, save transaction
- Each transaction stores: products, quantity, subtotal, total, payment, change, cashier, customer, timestamp

### Loyalty & Membership System
- Customers identified by phone number (auto-created on first transaction)
- Points earned automatically: 1% of transaction total
- **Point redemption at checkout**: points reduce the payable total, then reset to zero after use
- Supports both member and non-member transaction flows

### Sales History & Reporting
- Full transaction log with drill-down detail (member info, points, products, cashier, totals)
- Admin sees all transactions; cashiers see only their own (`Sale::where('user_id', Auth::user()->id)`)
- Invoice and PDF receipt generation (DomPDF)
- Excel export for sales data (Laravel Excel)

### Dashboards
- **Admin:** bar chart (transactions over time), pie chart (product sales distribution)
- **Cashier:** daily stats, including total transactions and the member vs. non-member split

## Architecture

```
                    ┌─────────────┐
                    │    LOGIN    │
                    │  reCAPTCHA  │
                    └──────┬──────┘
                           │
                 ┌─────────┴─────────┐
                 │                   │
              ADMIN               CASHIER
                 │                   │
        ┌────────┼────────┐      ┌───┴────┐
        │        │        │      │        │
    Dashboard  Product   User  Dashboard Sales
        │        │        │                │
     Charts    CRUD     CRUD               │
                                           │
                              ┌────────────┼────────────┐
                              │            │            │
                           Product      Member      Non-member
                              │            │            │
                              └──────┬─────┘            │
                                     │                  │
                                  Payment ──────────────┘
                                     │
                             ┌───────┴────────┐
                             │                │
                         Use Points       Earn Points
                             │                │
                             └───────┬────────┘
                                     │
                              Stock Adjustment
                                     │
                              Receipt / Invoice
                                     │
                              Excel Reporting
```

## What this project demonstrates

This project combines role-based access control, relational data modeling, inventory synchronization logic, a working loyalty points system, transactional sales workflows, and PDF/Excel reporting into a single coherent system rather than isolated features.

## Setup

### Requirements

- PHP 8.1+
- Composer
- MySQL
- Node.js & npm

### Installation

Clone the repository and install the PHP dependencies:

```bash
git clone https://github.com/hidayatmramon/pos-cashier-loyalty-system.git
cd pos-cashier-loyalty-system
composer install
```

Create the environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure your database credentials in `.env`:

```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Configure the Google reCAPTCHA v2 credentials:

```env
NOCAPTCHA_SITEKEY=your_site_key
NOCAPTCHA_SECRET=your_secret_key
```

Run the database migrations and seed the default admin account:

```bash
php artisan migrate --seed
```

Install the frontend dependencies:

```bash
npm install
```

Create the symbolic link for uploaded product images:

```bash
php artisan storage:link
```

Start the Vite development server and Laravel application:

```bash
npm run dev
```

In a separate terminal:

```bash
php artisan serve
```

The application will be available at:

```text
http://127.0.0.1:8000
```

### Default Admin Account

The database seeder creates an initial administrator account.

```text
Email: admin@example.com
Password: password
```

Change or remove the default credentials before deploying the application to a production environment.
