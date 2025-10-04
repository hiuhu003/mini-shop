# 🛍️ **Mini-Shop (Laravel)** — *Quick README*

> A tiny, clean Laravel e-commerce starter. Browse products, add to cart, choose a pickup station at checkout, and view your orders. Includes a lightweight admin panel for products, orders, and pickup stations.

---

## ✨ Features

* **Products:** CRUD with image uploads (public storage)
* **Cart & Checkout:** M-Pesa / Card *(demo inputs)*
* **Pickup Stations:** Select during checkout
* **User Orders:** List, details, cancel pending orders
* **Admin Orders:** Filter & update status
* **Inventory:** Low-stock badge & filter

---

## 🧰 Tech Stack

* **Backend:** Laravel 10+, PHP 8.1+
* **DB:** MySQL / MariaDB
* **UI:** Tailwind (CDN), Blade Views
* **Storage:** `public` disk (symlinked)

---

## 🚀 Quick Start

### 1) Requirements

* PHP ≥ 8.1, Composer
* MySQL 
* Node **optional** (Tailwind via CDN)

### 2) Install

```bash
git clone <your-repo-url> mini-shop
cd mini-shop
composer install
cp .env.example .env
php artisan key:generate
```

Create a database (e.g. `minishop`) and update `.env`:

```dotenv
DB_DATABASE=minishop
DB_USERNAME=root
DB_PASSWORD=
FILESYSTEM_DISK=public
```

### 3) Migrate & Seed

```bash
php artisan migrate --seed
php artisan storage:link
```



### 4) Run

```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000`

### 5) Demo Logins


* **Admin:** `admin@example.com` / `password`
* **User:**  `user@example.com`  / `password`


---

## 🧪 Handy Commands

```bash
# Reset DB and reseed
php artisan migrate:fresh --seed

# Clear caches
php artisan optimize:clear
```


