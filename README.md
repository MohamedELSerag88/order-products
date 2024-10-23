# Order System Management API

This project is a Laravel-based RESTful API designed to manage order system , payment and sent notifications.

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Database Setup](#database-setup)
- [Postman Collection](#postman-collection)
- [Unit Test Setup](#Unit-Test-Setup)

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/MohamedELSerag88/order-products.git
    cd order-products
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

## Configuration

1. **Environment variables:**

   Copy the `.env.example` file to `.env` and configure your environment variables such as database credentials, mail settings, etc.

    ```bash
    cp .env.example .env
    ```

2. **Database Configuration:**

   Set up your database configuration in the `.env` file:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=restaurant
    DB_USERNAME=root
    DB_PASSWORD=
    ```


## Database Setup

1. **Migrate the database:**

   Run the migrations to create the required tables and data.

    ```bash
    php artisan migrate
    ```

2. **Seed the database:**

    ```bash
    php artisan db:seed
    ```

## Postman Collection

1. **Import this collection:**

    ```
   can find postman collection file inside base directroy of the project 
   file name : Order System.postman_collection.json
   env file: Order System.postman_environment.json

    ```

## Unit Test Setup

1. **Unit test Configuration:**

Set up your database and stripe payment keys in the `phpunit.xml` file:

    ```
    <env name="DB_CONNECTION" value="mysql"/>
     <env name="DB_DATABASE" value="order_system"/>
     <env name="DB_USERNAME" value="root"/>
    <env name="DB_PASSWORD" value=""/>
    <env name="MAIL_MAILER" value="array"/>
    <env name="QUEUE_CONNECTION" value="sync"/>
    <env name="SESSION_DRIVER" value="array"/>
    ```
2. **Run command:**
    ```bash
    php artisan test --coverage-html=coverage/
    ```
