# Your Medical Store Ltd.

## Project README

**Project Type:**  Medical Store Ordering & Management System  
**Project Name:** Your Medical Store Ltd.  
**Backend:** PHP  
**Database:** MySQL  
**Frontend:** HTML, CSS, JavaScript  
**Architecture:** PHP + MySQL web application

---

## 1. Project Introduction

**Your Medical Store Ltd.** is a web-based medical store and B2B pharmaceutical ordering platform.

The system is designed to provide a professional online product browsing and ordering experience for pharmacies, hospitals, institutions, and business customers.

Customers can browse products, search products, filter products by category, check stock availability, view detailed product information, add available products to an order basket, and submit an order through checkout.

An administrator can access a protected dashboard to monitor products, stock, and recent orders and to update order status.

---

## 2. Main Objective

The main objective of **Your Medical Store Ltd.** is to create a simple, organized, and professional digital platform for medical product presentation and business ordering.

The system combines:

- Product management
- Product search
- Category filtering
- Stock checking
- Alternative product suggestions
- Order basket
- Checkout
- Order management
- Admin dashboard
- Stock management

into one web application.

---

## 3. Technologies Used

### Frontend

- HTML5
- CSS3
- JavaScript
- Responsive Web Design
- CSS Grid
- CSS Flexbox

### Backend

- PHP
- PHP Sessions
- PDO
- Prepared Statements

### Database

- MySQL
- UTF-8 / `utf8mb4`

### Development Environment

The project can be run using a local PHP/MySQL environment such as:

- XAMPP
- WAMP
- Laragon

---

## 4. Main Features

### Customer Features

- Home page
- Product portfolio
- Product search
- Category filtering
- Product details page
- Product stock availability
- Out-of-stock handling
- Alternative product recommendations
- Add product to order basket
- Remove product from basket
- Update basket quantity
- Checkout
- Order submission
- Payment method selection
- Payment system selection
- Order success message
- About platform information
- Contact / WhatsApp access

### Admin Features

- Admin login
- Session-based admin protection
- Admin dashboard
- Total product count
- Recent order count
- Pending order count
- Confirmed order count
- Cancelled order count
- Recent order table
- Order status update
- Product stock monitoring
- Available / out-of-stock status

---

## 5. Complete Project Workflow

```text
                     CUSTOMER
                        |
                        v
                  Home Page
                        |
                        v
                 Product Page
                        |
              +---------+---------+
              |                   |
              v                   v
         Search / Filter     View Product
                                  |
                                  v
                           Check Stock
                                  |
                    +-------------+-------------+
                    |                           |
                    v                           v
                 In Stock                 Out of Stock
                    |                           |
                    v                           v
               Add to Cart              Show Alternatives
                    |                           |
                    +-------------+-------------+
                                  |
                                  v
                            Order Basket
                                  |
                                  v
                              Checkout
                                  |
                                  v
                         Customer Information
                                  |
                                  v
                            Submit Order
                                  |
                                  v
                         Save Order in MySQL
                                  |
                                  v
                         Reduce Product Stock
                                  |
                                  v
                           Admin Dashboard
                                  |
                       +----------+----------+
                       |                     |
                       v                     v
                   Confirmed             Cancelled
                                             |
                                             v
                                      Restore Stock
```

---

## 6. Home Page

The home page introduces the medical store platform and provides navigation to the major parts of the website.

It contains sections such as:

- Hero section
- Professional B2B commerce introduction
- Product groups
- Featured products
- Ordering steps
- Footer
- WhatsApp contact button

The home page also provides direct navigation to the product portfolio.

---

## 7. Product Portfolio

The product portfolio displays the available products from the database.

Each product can show:

- Product image
- Product name
- Generic name
- Dosage form
- Strength
- Category
- Price
- Stock status
- View button
- Add button

Products are loaded dynamically from MySQL.

---

## 8. Product Search

The product page supports keyword searching.

The search keyword is received through a GET parameter:

```text
?q=keyword
```

The system checks product information including:

- Product name
- Generic name
- Category
- Company information when available

The search is converted to lowercase using `strtolower()` so that the comparison is not dependent on letter case.

---

## 9. Category Filtering

Customers can filter products by category.

The category list is loaded from the database.

Examples of categories supplied in the project include:

- Antiulcerants
- Antibiotics
- Cardiovascular
- Antidiabetics
- Vitamins & Supplements
- Personal Care

Search and category filtering can be used together.

---

## 10. Product Details

The product details page provides a larger and more complete view of a product.

It can display:

- Product image
- Category
- Product name
- Company information
- Price
- Description
- Generic name
- Strength
- Dosage form
- Pack size
- Current stock

If the product is available, the customer can add it to the order basket.

If the product is unavailable, the system displays alternative available products.

---

## 11. Alternative Product System

The project contains an alternative-product feature for unavailable products.

When a product is out of stock, the system calls the alternative product logic.

The intended priority is:

```text
1. Same generic name + same strength
2. Same generic name
3. Stock must be greater than zero
4. The original product is excluded
```

This feature helps customers find another available product when the selected product is unavailable.

---

## 12. Order Basket / Cart

The order basket is stored using PHP sessions.

The cart keeps track of:

```text
Product ID
Quantity
```

Main cart operations are:

- Add product
- Remove product
- Update quantity
- Check stock
- Prevent unavailable products from being ordered
- Calculate estimated total

The cart count is displayed in the website navigation.

---

## 13. Checkout

The checkout page loads the customer's cart and verifies the products again.

The checkout process:

1. Reads the session cart.
2. Loads products from the database.
3. Checks whether products still exist.
4. Checks current stock.
5. Removes unavailable products.
6. Prevents quantity from exceeding available stock.
7. Calculates product subtotal.
8. Calculates total amount.
9. Collects customer information.
10. Inserts order information into the database.
11. Inserts order-item information.
12. Decreases product stock.
13. Commits the transaction.
14. Clears the cart.

---

## 14. Customer Checkout Information

The current checkout implementation collects:

- Contact Person
- Phone Number
- Payment Method
- Payment System

Available payment methods in the supplied code include:

- Cash on Delivery
- Online Payment

Available payment systems include:

- bKash
- Nagad
- Rocket
- Bank

Orders are initially stored with:

```text
Pending
```

status.

---

## 15. Stock Management

Stock is checked throughout the ordering process.

The system checks stock when:

- Products are displayed
- Product details are opened
- Products are added to the cart
- Cart quantities are processed
- Checkout is submitted
- Admin views the dashboard

During checkout, stock is checked again before it is reduced.

This is important because stock may change after a customer first adds a product to the basket.

---

## 16. Order Status

The admin dashboard supports order status management.

The supplied dashboard uses:

```text
Pending
Confirmed
Cancelled
```

When an order is cancelled, the system is designed to return the ordered quantity to product stock.

The cancellation logic checks that the previous status was not already cancelled, helping prevent the same quantity from being restored multiple times.

---

## 17. Admin Dashboard

The admin dashboard is the main management area.

It displays:

### Dashboard Metrics

- Total Products
- Recent Orders
- Pending Orders
- Confirmed Orders
- Cancelled Orders

### Recent Orders

The order table displays information such as:

- Order ID
- Owner
- Phone
- Medicine
- Company
- Quantity
- Price
- Payment Method
- Payment System
- Order Status
- Date
- Action

### Products

The product table displays:

- Product
- Generic
- Company
- Category
- Price
- Stock
- Availability

---

## 18. Admin Authentication

The admin dashboard checks the PHP session before allowing access.

If the admin session is not present, the user is redirected to the admin login page.

The supplied development login uses a fixed credential check in the PHP login code.

### Recommended improvement for real deployment

For production, the login should be changed to:

- Database-based admin users
- `password_hash()`
- `password_verify()`
- Session ID regeneration after login
- CSRF protection
- Login rate limiting
- Environment-based secrets

The credentials in development code should never be exposed in a public production repository.

---

## 19. Database

The supplied project uses the database:

```text
pharmasia_ecommerce
```

The SQL supplied with the project creates the following tables.

### categories

Stores product categories.

Main fields:

```text
id
name
slug
```

### products

Stores product information.

Main fields:

```text
id
category_id
name
generic_name
strength
dosage_form
pack_size
price
stock
image_url
description
created_at
```

### users

Stores customer/admin information.

Main fields include:

```text
id
name
business_name
phone
email
drug_license
address
password_hash
role
created_at
```

### orders

Stores order information.

### order_items

Stores order-item information.

---

## 20. Database Connection

The project uses PDO for MySQL connection.

The supplied local configuration uses:

```text
Host: localhost
Database: pharmasia_ecommerce
Username: root
Password: empty
Charset: utf8mb4
```

The project uses PDO exception mode and associative fetch mode.

---

## 21. PHP Helper Functions

The project contains reusable PHP functions for common operations.

Examples include:

### `h()`

Used to escape HTML output with `htmlspecialchars()`.

### `db_all()`

Used to execute a query and return multiple rows.

### `db_one()`

Used to return a single database row.

### `db_execute()`

Used to execute a database statement.

### `products()`

Loads products with their category.

### `categories()`

Loads product categories.

### `product_find()`

Finds one product by ID.

### `product_stock()`

Returns the current stock quantity.

### `alternative_products()`

Finds available alternatives for an unavailable product.

### `cart_count()`

Returns the number of items stored in the session cart.

---

## 22. Security Practices

The project already uses several useful security practices.

### Prepared Statements

PDO prepared statements are used for database operations.

### Output Escaping

The `h()` helper is used when displaying values in HTML.

### Session Protection

The admin dashboard requires an authenticated admin session.

### Database Transactions

Checkout and stock-restoration operations use transactions.

### Stock Validation

The system validates stock before reducing inventory.

---

## 23. Frontend Design

The website uses a modern responsive interface.

The CSS includes:

- CSS variables
- Product cards
- Rounded corners
- Shadows
- Hover animations
- Hero sections
- Responsive grids
- Mobile layouts
- Navigation
- Floating WhatsApp button
- Admin login styling

The main color system includes red, navy, white, grey, and green status colors.

---

## 24. JavaScript

The supplied JavaScript provides:

- Mobile navigation toggle
- Reveal animations using `IntersectionObserver`
- Scroll-to-top behavior
- Scroll state detection
- Password show/hide functionality

---

## 25. Recommended Folder Structure

A clean final project can be organized like this:

```text
Your-Medical-Store-Ltd/
│
├── index.php
├── products.php
├── view.php
├── product-details.php
├── cart.php
├── checkout.php
├── about.php
├── contact.php
├── header.php
├── footer.php
│
├── config/
│   └── db.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   │
│   └── js/
│       └── script.js
│
├── admin/
│   ├── login.php
│   └── dashboard.php
│
└── database/
    └── pharmasia_ecommerce.sql
```

The exact filenames should match the final project folder.

---

## 26. Installation

### Step 1

Install XAMPP, WAMP, or Laragon.

### Step 2

Place the project inside the server web root.

For XAMPP:

```text
htdocs/Your-Medical-Store-Ltd/
```

### Step 3

Start:

```text
Apache
MySQL
```

### Step 4

Open phpMyAdmin.

Create/import the supplied database SQL.

Database:

```text
pharmasia_ecommerce
```

### Step 5

Check:

```text
config/db.php
```

and configure the MySQL username/password for the local environment.

### Step 6

Open:

```text
http://localhost/project.php
```

---

## 27. Important Final-Project Consistency Check

The supplied source code was created in multiple sections, so before final submission the database fields and page filenames should be made consistent.

For example, the supplied code references fields such as:

```text
company
company_name
owner_name
phone_number
order_status
order_date
product_id
```

The supplied SQL schema should be checked against those fields and updated so that the PHP code and MySQL tables use exactly the same structure.

Also, some supplied product links use:

```text
view.php
```

while other code refers to:

```text
product-details.php
```

The final project should choose one product-details page and update all links accordingly.

This consistency check is important before presenting or deploying the project.

---

## 28. Future Improvements

Possible future improvements include:

- Database-based admin authentication
- Customer registration and login
- Pharmacy verification
- Drug-license verification
- Admin product CRUD
- Admin category CRUD
- Product image upload
- Customer order history
- Invoice generation
- Low-stock alerts
- Sales reports
- Delivery tracking
- Email notifications
- Real payment gateway integration
- CSRF protection
- Audit logs
- Pagination
- Database-side product search
- HTTPS deployment

---

## 29. Short Project Description

**Your Medical Store Ltd. is a PHP and MySQL based B2B medical store ordering and management system. It allows customers to browse medical products, search and filter products, view product details, check stock availability, find alternative products when an item is unavailable, add products to an order basket, and submit orders through checkout. The system also provides an admin dashboard for monitoring products, stock and orders and for updating order status.**

---

## 30. Viva / Presentation Summary

For a short presentation, the project can be explained as follows:

> “My project is Your Medical Store Ltd., a web-based B2B medical store ordering and management system. I developed the system using HTML, CSS and JavaScript for the frontend, PHP for the backend, and MySQL for database management. Customers can browse products, search and filter medicines, check stock, view product details, add available products to the order basket and submit orders through checkout. The system also provides alternative products when a selected product is out of stock. On the admin side, the administrator can monitor products and orders, update order status and manage the stock workflow. PDO, prepared statements, PHP sessions and database transactions are used in the system.”

---

## 31. Project Purpose

The project demonstrates the practical use of:

```text
HTML
CSS
JavaScript
PHP
MySQL
PDO
Sessions
SQL
Database Transactions
Responsive Design
Inventory Logic
Order Management
```

The overall purpose is to provide a structured digital ordering workflow for **Your Medical Store Ltd.**

---

## 32. Note

This README is based on the project code and SQL shared for this project. The final deployment should use one consistent project name, database schema, page naming convention, and authentication system.
