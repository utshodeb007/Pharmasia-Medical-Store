CREATE DATABASE IF NOT EXISTS pharmasia_ecommerce
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE pharmasia_ecommerce;

CREATE TABLE categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
slug VARCHAR(120) NOT NULL UNIQUE
);

CREATE TABLE products (
id INT AUTO_INCREMENT PRIMARY KEY,
category_id INT,
name VARCHAR(150) NOT NULL,
generic_name VARCHAR(150),
strength VARCHAR(80),
dosage_form VARCHAR(80),
pack_size VARCHAR(80),
price DECIMAL(10,2) DEFAULT 0,
stock INT NOT NULL DEFAULT 10,
image_url TEXT,
description TEXT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY(category_id) REFERENCES categories(id)
);

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(120),
business_name VARCHAR(160),
phone VARCHAR(40),
email VARCHAR(120),
drug_license VARCHAR(100),
address TEXT,
password_hash VARCHAR(255),
role ENUM('customer','admin') DEFAULT 'customer',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NULL,
buyer_name VARCHAR(150),
phone VARCHAR(40),
drug_license VARCHAR(120),
address TEXT,
total DECIMAL(10,2) DEFAULT 0,
status ENUM('Pending','Approved','Delivered','Cancelled') DEFAULT 'Pending',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
id INT AUTO_INCREMENT PRIMARY KEY,
order_id INT,
product_id INT,
quantity INT,
unit_price DECIMAL(10,2)
);

INSERT INTO categories(name,slug) VALUES
('Antiulcerants','antiulcerants'),
('Antibiotics','antibiotics'),
('Cardiovascular','cardiovascular'),
('Antidiabetics','antidiabetics'),
('Vitamins & Supplements','vitamins'),
('Personal Care','personal-care');

INSERT INTO products
(category_id,name,generic_name,strength,dosage_form,pack_size,price,stock,image_url,description)
VALUES
(1,'Pantozid 40','Pantoprazole','40 mg','Tablet','10 x 10',120,0,'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=900&q=80','A gastro care product presentation for institutional and pharmacy supply requests.'),
(1,'Pantosec 40','Pantoprazole','40 mg','Tablet','10 x 10',115,20,'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?auto=format&fit=crop&w=900&q=80','Alternative brand of Pantoprazole.'),
(2,'Azimax 500','Azithromycin','500 mg','Tablet','3 x 10',210,0,'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?auto=format&fit=crop&w=900&q=80','Prescription antibacterial.'),
(2,'Azi 500','Azithromycin','500 mg','Tablet','3 x 10',205,30,'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?auto=format&fit=crop&w=900&q=80','Alternative brand.'),
(3,'Cardioplus 5','Amlodipine','5 mg','Tablet','10 x 10',95,15,'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=80','Cardiovascular portfolio item.'),
(4,'Glucomet 500','Metformin Hydrochloride','500 mg','Tablet','10 x 10',85,18,'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?auto=format&fit=crop&w=900&q=80','Diabetes care product.'),
(5,'Vital B Complex','Vitamin B Complex','Standard','Tablet','10 x 10',70,40,'https://images.unsplash.com/photo-1550572017-edd951aa8f72?auto=format&fit=crop&w=900&q=80','Nutritional support item.'),
(6,'DermaClean','Antiseptic Skin Cleanser','100 ml','Liquid','1 bottle',160,12,'https://images.unsplash.com/photo-1607619056574-7b8d3ee536b2?auto=format&fit=crop&w=900&q=80','Personal care product.');
