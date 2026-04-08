# Avico Digital Magazine Platform

[![Laravel 8](https://img.shields.io/badge/Framework-Laravel%208-red)](https://laravel.com)
[![MySQL](https://img.shields.io/badge/Database-MySQL-blue)](https://www.mysql.com/)
[![AWS S3](https://img.shields.io/badge/Storage-Amazon%20AWS%20S3-orange)](https://aws.amazon.com/s3/)

This project is a comprehensive **Scientific Magazine Management System**, currently being adapted as my **Graduation Thesis (TCC)** in Software Engineering at the Federal University of Pampa (UNIPAMPA). It is designed to manage the entire editorial workflow of academic publications.

---

<p align="center">
  <strong style="font-size: 1.2em;">Platform Demo</strong><br><br>
  <video src="https://github.com/user-attachments/assets/88f26919-67f1-449a-a847-b5787b9e4fce" controls width="800" title="Avico Magazine Platform Demo"></video>
  <br>
</p>

---

## Key Engineering Features

* **Role-Based Access Control (RBAC):** Implementation of a complex permission system using `spatie/laravel-permission`, defining clear workflows for **Authors, Reviewers, Editors, and Editors-in-Chief**.
* **Cloud Infrastructure:** Integrated with **Amazon AWS S3** for secure and scalable storage of scientific manuscripts and media files.
* **Full-Stack Architecture:** Developed with **Laravel 8**, utilizing MVC patterns to ensure a clean separation of concerns and maintainable code.
* **Automated Testing:** Project includes a foundation for Black-Box automated testing to ensure platform reliability.

---

## Tech Stack

* **Backend & Frontend:** Laravel 8 (PHP)
* **Authentication & UI:** Laravel UI with Vue.js components.
* **Database:** MySQL Workbench for relational data modeling.
* **Cloud Services:** Amazon AWS (Simple Storage Service - S3).

---

## Setup & Installation

### 1. Environment Requirements
* PHP >= 8.1
* Composer
* MySQL
* Git

### 2. Installation Steps
```bash
# Clone the repository
git clone https://github.com/EduardoSalbego/revista-avico.git

# Install dependencies
composer install
composer require laravel/ui
composer require spatie/laravel-permission

# Configure environment
cp .env.example .env
# Important: Update .env with your MySQL and AWS S3 credentials

# Setup UI and Authentication
php artisan ui vue --auth
npm install && npm run dev

# Run Migrations and Initialize Roles
php artisan migrate
php artisan permission:create-role autor
php artisan permission:create-role avaliador
php artisan permission:create-role editor
php artisan permission:create-role editor-chefe
```

### 3. Execution
```bash
php artisan serve
```

## Developed by
**Eduardo Salbego** Software Engineering Student | Final Year / 9th Semester @ UNIPAMPA
