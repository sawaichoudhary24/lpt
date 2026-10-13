CREATE DATABASE IF NOT EXISTS lpt_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE lpt_store;
CREATE TABLE IF NOT EXISTS admins(id INT AUTO_INCREMENT PRIMARY KEY,email VARCHAR(150) UNIQUE,password VARCHAR(255));
CREATE TABLE IF NOT EXISTS users(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(120),email VARCHAR(150) UNIQUE,phone VARCHAR(20),password VARCHAR(255),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS categories(id INT AUTO_INCREMENT PRIMARY KEY,name VARCHAR(120),slug VARCHAR(150) UNIQUE,section_title VARCHAR(200) DEFAULT '',sort_order INT DEFAULT 0);
CREATE TABLE IF NOT EXISTS products(id INT AUTO_INCREMENT PRIMARY KEY,category_id INT,name VARCHAR(255),slug VARCHAR(280) UNIQUE,short_desc TEXT,description MEDIUMTEXT,price DECIMAL(10,2) DEFAULT 0,mrp DECIMAL(10,2) DEFAULT 0,rating DECIMAL(2,1) DEFAULT 5.0,rating_text VARCHAR(20) DEFAULT '',sold INT DEFAULT 0,language VARCHAR(50) DEFAULT 'English',ptype VARCHAR(30) DEFAULT 'Books',frequency VARCHAR(20) DEFAULT '',in_stock TINYINT DEFAULT 1,stock_qty INT DEFAULT 0,image VARCHAR(255) DEFAULT '',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS product_images(id INT AUTO_INCREMENT PRIMARY KEY,product_id INT,image VARCHAR(255));
CREATE TABLE IF NOT EXISTS orders(id INT AUTO_INCREMENT PRIMARY KEY,order_no VARCHAR(30),user_id INT,name VARCHAR(120),phone VARCHAR(20),email VARCHAR(150),address TEXT,city VARCHAR(100),state VARCHAR(100),pincode VARCHAR(10),total DECIMAL(10,2),payment VARCHAR(30) DEFAULT 'COD',status VARCHAR(20) DEFAULT 'Pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS order_items(id INT AUTO_INCREMENT PRIMARY KEY,order_id INT,product_id INT,name VARCHAR(255),price DECIMAL(10,2),qty INT,image VARCHAR(255));

INSERT IGNORE INTO categories(id,name,slug,section_title,sort_order) VALUES
(1,'CLAT UG','clat-ug','Popular CLAT UG Books',1),(2,'CLAT PG','clat-pg','Popular CLAT PG Books',2),(3,'IPMAT','ipmat','Popular IPMAT Books',3),
(4,'AILET','ailet','Popular AILET Books',4),(5,'Judiciary','judiciary','Popular Judiciary Books',5),(6,'T-Shirts','t-shirts','Popular T-Shirts',6);

INSERT IGNORE INTO products(id,category_id,name,slug,short_desc,description,price,mrp,rating,rating_text,sold,ptype,frequency) VALUES
(1,1,'CLAT Champions Toolkit (CTK) | 5 Section-Wise Booklets | 1300+ Questions, 170+...','clat-champions-toolkit','Five section-wise booklets for CLAT preparation.','<p>Sample description. Admin panel se edit karo.</p>',4000,6000,4.9,'4k',4000,'Bookset',''),
(2,1,'CLAT Express Monthly GK & Current Affairs Magazine | For CLAT, AILET, SLAT & Law...','clat-express-monthly-gk','Monthly printed GK and current affairs magazine.','<p>Sample description.</p>',3500,5000,4.8,'23k',35291,'Magazine','monthly'),
(3,1,'CLAT Game Changer Kit | 40+ Books, 50+ Mocks, 400+ Tests & CLAT Express','clat-game-changer-kit','Complete CLAT kit.','<p>Sample description.</p>',15000,35000,4.8,'9k',9000,'Combo Pack',''),
(4,1,'Legal Express Magazine | Monthly Legal Current Affairs, Important Judgments &...','legal-express-magazine','Monthly legal current affairs.','<p>Sample description.</p>',2200,5000,4.9,'2k',2000,'Magazine','monthly'),
(5,2,'Bharatiya Nyaya Sanhita (BNS): Book for CLAT PG','bns-clat-pg','BNS book.','<p>Sample.</p>',1050,1200,4.9,'205',205,'Books',''),
(6,2,'Hindu Law Book for CLAT PG (Family Law)','hindu-law-clat-pg','Hindu Law.','<p>Sample.</p>',500,600,5.0,'102',102,'Books',''),
(7,5,'Civil Procedure Code (CPC) Book for Judiciary Exams 2026-27','cpc-judiciary','CPC.','<p>Sample.</p>',750,1000,5.0,'3k',3000,'Books',''),
(8,5,'Constitution of India: Book for Judiciary Exams','constitution-judiciary','Constitution.','<p>Sample.</p>',640,1000,4.8,'592',592,'Books','');
