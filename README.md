# 💊 Pharmasia Medical Store
### Web-Based B2B Pharmaceutical Ordering & Management System

<p align="center">

**A Modern Medical Store Ordering and Inventory Management Platform**

</p>

---

## 👨‍💻 Developer Information

| Information | Details |
|---|---|
| Developer Name | Utsho Kumar Deb |
| University | Northern University Bangladesh |
| Department | Computer Science and Engineering (CSE) |
| Project Name | Pharmasia Medical Store |
| Project Type | Web-Based B2B Medical Store Management System |
| GitHub Repository | [Pharmasia Medical Store](https://github.com/utshodeb007/Pharmasia-Medical-Store) |

---

## 1. Project Overview

**Pharmasia Medical Store** is a web-based B2B pharmaceutical ordering and management system developed to provide a professional digital platform for pharmacies, hospitals, institutions, and business customers.

The system allows customers to browse medical products, search medicines, filter products by category, check stock availability, view product details, add products to a shopping cart, and submit orders.

It also provides an administrative dashboard for managing products, monitoring inventory, tracking orders, and updating order statuses.

The project is developed using PHP, MySQL, HTML, CSS, and JavaScript.

## 2. Project Introduction

The main purpose of this project is to simplify medical product browsing, ordering, and inventory management through a web-based application.

The platform provides two major interfaces:

- Customer Interface
- Administrator Interface

Customers can explore available pharmaceutical products and place orders, while administrators can monitor products, stock, and customer orders.

## 3. Project Objectives

The main objectives are:

- Develop a web-based medical store platform.
- Provide an organized pharmaceutical product catalog.
- Implement product searching and category filtering.
- Display real-time database stock information.
- Provide alternative product recommendations.
- Implement shopping cart functionality.
- Develop a secure checkout workflow.
- Manage customer orders.
- Provide an administrative dashboard.
- Improve inventory and stock management.

## 4. Technologies Used

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
- SQL
- UTF-8 / utf8mb4

### Development Environment
- Visual Studio Code
- XAMPP
- phpMyAdmin
- Localhost

## 5. Main Features

### Customer Features

- Modern homepage
- Product portfolio
- Product search
- Category filtering
- Product details
- Product image display
- Product stock availability
- Out-of-stock handling
- Alternative product recommendations
- Add to cart
- Remove from cart
- Update cart quantity
- Checkout system
- Customer information collection
- Payment method selection
- Order submission
- Order success message
- About page
- Contact page
- WhatsApp contact access

### Admin Features

- Admin login
- Session-based authentication
- Admin dashboard
- Total product count
- Recent order monitoring
- Pending order count
- Confirmed order count
- Cancelled order count
- Recent order table
- Order status management
- Product stock monitoring
- Available and out-of-stock status

## 6. Complete Project Workflow

```text
                  CUSTOMER
                     |
                     v
                  Home Page
                     |
                     v
                 Product Page
                     |
             Search / Category
                     |
                     v
               View Product
                     |
                     v
                 Check Stock
                     |
           +---------+---------+
           |                   |
           v                   v
        In Stock           Out of Stock
           |                   |
           v                   v
       Add to Cart       Alternative Products
           |                   |
           +---------+---------+
                     |
                     v
                 Shopping Cart
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
               Save to MySQL
                     |
                     v
              Update Product Stock
                     |
                     v
              Admin Dashboard
                     |
             +-------+-------+
             |               |
             v               v
          Confirmed       Cancelled
                             |
                             v
                       Restore Stock
```

## 7. Home Page

The homepage introduces the medical store platform and provides navigation to the main website sections.

It includes:

- Hero section
- B2B commerce introduction
- Product groups
- Featured products
- Ordering steps
- Navigation menu
- Footer section
- WhatsApp contact button

## 8. Product Portfolio

The product portfolio displays available products dynamically from the MySQL database.

Each product can display:

- Product image
- Product name
- Generic name
- Dosage form
- Strength
- Category
- Price
- Stock status
- View button
- Add to cart button

## 9. Product Search

The product page supports keyword-based searching.

Search functionality can check:

- Product name
- Generic name
- Category
- Company information when available

The supplied implementation uses PHP string handling, including `strtolower()`, for case-insensitive comparison.

## 10. Category Filtering

Customers can filter pharmaceutical products by category.

Example categories include:

- Antiulcerants
- Antibiotics
- Cardiovascular
- Antidiabetics
- Vitamins & Supplements
- Personal Care

Search and category filtering can be used together.

## 11. Product Details

The product details page displays complete information about a selected product.

Information includes:

- Product image
- Product name
- Category
- Company information
- Price
- Description
- Generic name
- Strength
- Dosage form
- Pack size
- Current stock

Customers can add available products to their cart.

## 12. Alternative Product Recommendation System

The system includes an alternative product recommendation feature.

When a product is out of stock, the application searches for other available products.

Recommendation priority:

1. Same generic name and same strength.
2. Same generic name.
3. Stock quantity greater than zero.
4. Exclude the originally selected product.

The PHP function `alternative_products()` implements this functionality.

## 13. Shopping Cart System

The shopping cart uses PHP sessions to temporarily store selected products.

Cart information includes:

- Product ID
- Quantity

Main operations:

- Add product
- Remove product
- Update quantity
- Validate stock
- Prevent unavailable products from being ordered
- Calculate estimated total
- Display cart count

## 14. Checkout System

The checkout system processes customer orders.

Checkout workflow:

1. Read the session cart.
2. Load products from MySQL.
3. Check whether products exist.
4. Verify current stock.
5. Remove unavailable products.
6. Validate requested quantities.
7. Calculate subtotal.
8. Calculate total amount.
9. Collect customer information.
10. Insert order information.
11. Insert order items.
12. Decrease product stock.
13. Commit the database transaction.
14. Clear the shopping cart.

## 15. Customer Checkout Information

The current checkout implementation collects:

- Contact Person
- Phone Number
- Payment Method
- Payment System

Available payment methods:

- Cash on Delivery
- Online Payment

Available payment systems:

- bKash
- Nagad
- Rocket
- Bank

New orders are initially assigned:

`Pending`

## 16. Stock Management System

Stock management is an important part of the application.

The system checks product availability during:

- Product display
- Product details viewing
- Adding products to cart
- Cart quantity updates
- Checkout
- Admin dashboard monitoring

Stock is verified again during checkout before reducing inventory.

## 17. Order Status Management

The admin dashboard supports three order statuses:

- Pending
- Confirmed
- Cancelled

When an order is cancelled, the application is designed to restore the previously ordered quantity to product stock.

The cancellation logic checks the previous status to help prevent duplicate stock restoration.

## 18. Admin Dashboard

The administrative dashboard provides an overview of the medical store.

### Dashboard Metrics

- Total Products
- Recent Orders
- Pending Orders
- Confirmed Orders
- Cancelled Orders

### Recent Orders Table

The dashboard can display:

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

### Product Information

- Product
- Generic
- Company
- Category
- Price
- Stock
- Availability

## 19. Admin Authentication

The admin dashboard uses PHP sessions to restrict access.

If an administrator is not authenticated, the application redirects the user to the admin login page.

The supplied development implementation uses a fixed credential check.

Recommended production improvements:

- Database-based admin accounts
- `password_hash()`
- `password_verify()`
- Session ID regeneration
- CSRF protection
- Login rate limiting
- Environment-based credentials

## 20. Database Design

The project uses MySQL as its database management system.

Database name:

`pharmasia_ecommerce`

The supplied SQL schema includes the following tables:

### categories

Stores product categories.

Main fields:

- id
- name
- slug

### products

Stores pharmaceutical product information.

Main fields:

- id
- category_id
- name
- generic_name
- strength
- dosage_form
- pack_size
- price
- stock
- image_url
- description
- created_at

### users

Stores customer and administrator information.

Main fields include:

- id
- name
- business_name
- phone
- email
- drug_license
- address
- password_hash
- role
- created_at

### orders

Stores customer order information.

### order_items

Stores individual items associated with customer orders.

## 21. Database Connection

The project uses PHP PDO to connect with MySQL.

Local development configuration:

| Configuration | Value |
|---|---|
| Host | localhost |
| Database | pharmasia_ecommerce |
| Username | root |
| Password | Empty for the supplied local configuration |
| Charset | utf8mb4 |

The application uses PDO exception mode and associative fetch mode.

Database credentials should be configured locally and must not be exposed in a public repository.

## 22. PHP Helper Functions

The project includes reusable PHP functions.

| Function | Purpose |
|---|---|
| `h()` | Escapes HTML output |
| `db_all()` | Returns multiple database rows |
| `db_one()` | Returns one database row |
| `db_execute()` | Executes database statements |
| `products()` | Loads products with categories |
| `categories()` | Loads product categories |
| `product_find()` | Finds a product by ID |
| `product_stock()` | Retrieves product stock |
| `alternative_products()` | Finds alternative available products |
| `cart_count()` | Calculates session cart quantity |

These functions help organize database operations and reduce repeated code.

## 23. Security Practices

The project implements several useful security practices:

### PDO Prepared Statements

Used for database queries and parameterized operations.

### Output Escaping

The `h()` helper uses `htmlspecialchars()` to escape HTML output.

### Session Protection

The admin dashboard checks authentication through PHP sessions.

### Database Transactions

Transactions are used in checkout and stock-restoration operations.

### Stock Validation

Product availability is checked before completing an order.

Additional security improvements are recommended before production deployment.

## 24. Frontend Design

The application uses a modern responsive interface.

The CSS implementation includes:

- CSS variables
- Product cards
- Rounded corners
- Box shadows
- Hover animations
- Hero sections
- Responsive grids
- Mobile layouts
- Navigation
- Floating WhatsApp button
- Admin login styling

The design uses a color system containing red, navy, white, grey, and green status colors.

## 25. JavaScript Functionality

The supplied JavaScript provides:

- Mobile navigation toggle
- Reveal animations
- IntersectionObserver
- Scroll-to-top behavior
- Scroll state detection
- Password show/hide functionality

These features improve website interaction and usability.

## 26. Project Folder Structure

The main project structure is:

```text
Pharmasia-Medical-Store/
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
│       └── main.js
│
├── admin/
│   ├── login.php
│   └── dashboard.php
│
├── database.sql
│
├── .gitignore
│
└── README.md
```

The actual filenames should match the project repository.

## 27. Installation Guide

Follow these steps to run the project locally.

### Step 1: Install XAMPP

Download and install XAMPP.

### Step 2: Copy the Project

Place the project folder inside the XAMPP `htdocs` directory.

Example:

```text
htdocs/Pharmasia-Medical-Store/
```

### Step 3: Start Services

Start:

- Apache
- MySQL

### Step 4: Create Database

Open phpMyAdmin.

Create or import the supplied SQL database.

Database name:

```sql
pharmasia_ecommerce
```

Import:

```text
database.sql
```

### Step 5: Configure Database

Open the local database configuration file:

```text
config/db.php
```

Configure the database host, username, password, and database name according to your local environment.

This file is excluded from the public GitHub repository.

### Step 6: Run the Project

Open the following URL in your browser:

```text
http://localhost/Pharmasia-Medical-Store/
```

The exact URL depends on the folder name and local server configuration.

## 28. Important Project Consistency Checks

Before final deployment, the following points should be checked:

### Database Field Consistency

The PHP files may reference fields such as:

- company
- company_name
- owner_name
- phone_number
- order_status
- order_date
- product_id

The SQL schema should match the actual PHP queries and database operations.

### Product Details Page

The project contains both:

```text
view.php
```

and

```text
product-details.php
```

Product links should consistently use the intended details page.

### Database Configuration

The local database configuration must be provided separately and should not be committed publicly.

## 29. Future Improvements

Possible future development includes:

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

## 30. Short Project Description

**Pharmasia Medical Store** is a PHP and MySQL-based B2B medical store ordering and management system. It allows customers to browse medical products, search and filter medicines, view product details, check stock availability, find alternative products when an item is unavailable, add products to the shopping cart, and submit orders through checkout.

The system also provides an administrative dashboard for monitoring products, stock, and customer orders and updating order statuses.

## 31. Viva and Presentation Summary

The project can be explained during a presentation as follows:

"My project is Pharmasia Medical Store, a web-based B2B medical store ordering and management system. I developed this application using HTML, CSS, and JavaScript for the frontend, PHP for the backend, and MySQL for database management.

Customers can browse pharmaceutical products, search and filter medicines, check stock availability, view product details, add products to the shopping cart, and submit orders through checkout.

The system also provides alternative product recommendations when a selected product is out of stock.

On the administrative side, the administrator can monitor products and customer orders, update order statuses, and manage stock information.

PDO, prepared statements, PHP sessions, and database transactions are used in the application."

## 32. Project Purpose and Conclusion

The project demonstrates the practical application of:

```text
HTML5
CSS3
JavaScript
PHP
MySQL
PDO
PHP Sessions
SQL
Database Transactions
Responsive Web Design
Inventory Management
Order Management
```

The overall purpose of Pharmasia Medical Store is to provide an organized digital platform for pharmaceutical product browsing, business ordering, inventory monitoring, and administrative management.

This project represents the practical implementation of web development, database management, backend programming, and responsive frontend design.

---

## 🔗 GitHub Repository

**Project:** Pharmasia Medical Store

**Repository:**  
https://github.com/utshodeb007/Pharmasia-Medical-Store

**Developer:** Utsho Kumar Deb

**University:** Northern University Bangladesh

---

<p align="center">

**Developed by Utsho Kumar Deb**

**Department of Computer Science and Engineering**

**Northern University Bangladesh**

</p>
