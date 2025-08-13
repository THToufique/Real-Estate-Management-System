-- ===============================================
-- REAL ESTATE MANAGEMENT SYSTEM - COMPLETE SQL PROJECT
-- ===============================================

-- DATABASE CREATION
-- CREATE DATABASE RealEstateDB;
USE RealEstateDB;

-- ===============================================
-- TABLE CREATION
-- ===============================================

-- 1. AGENTS TABLE
CREATE TABLE Agents (
    agent_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    commission_rate DECIMAL(5,2) DEFAULT 2.5,
    hire_date DATE NOT NULL,
    experience_years INT DEFAULT 0,
    status ENUM('Active', 'Inactive') DEFAULT 'Active'
);

-- 2. OWNERS TABLE
CREATE TABLE Owners (
    owner_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    address TEXT,
    registration_date DATE DEFAULT (CURRENT_DATE)
);

-- 3. CUSTOMERS TABLE
CREATE TABLE Customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    budget_min DECIMAL(12,2),
    budget_max DECIMAL(12,2),
    preferred_location VARCHAR(100),
    customer_type ENUM('Buyer', 'Renter') NOT NULL,
    registration_date DATE DEFAULT (CURRENT_DATE)
);

-- 4. PROPERTIES TABLE
CREATE TABLE Properties (
    property_id INT PRIMARY KEY AUTO_INCREMENT,
    owner_id INT NOT NULL,
    agent_id INT,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zipcode VARCHAR(10),
    property_type ENUM('House', 'Apartment', 'Commercial', 'Land') NOT NULL,
    bedrooms INT DEFAULT 0,
    bathrooms INT DEFAULT 0,
    area_sqft DECIMAL(10,2),
    price DECIMAL(12,2) NOT NULL,
    status ENUM('Available', 'Sold', 'Rented', 'Under Contract') DEFAULT 'Available',
    listing_date DATE DEFAULT (CURRENT_DATE),
    description TEXT,
    FOREIGN KEY (owner_id) REFERENCES Owners(owner_id),
    FOREIGN KEY (agent_id) REFERENCES Agents(agent_id)
);

-- 5. PROPERTY VIEWINGS TABLE
CREATE TABLE Property_Viewings (
    viewing_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    customer_id INT NOT NULL,
    agent_id INT NOT NULL,
    viewing_date DATETIME NOT NULL,
    feedback TEXT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    interested ENUM('Yes', 'No', 'Maybe') DEFAULT 'Maybe',
    FOREIGN KEY (property_id) REFERENCES Properties(property_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (agent_id) REFERENCES Agents(agent_id)
);

-- 6. TRANSACTIONS TABLE
CREATE TABLE Transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    buyer_id INT NOT NULL,
    seller_id INT NOT NULL,
    agent_id INT NOT NULL,
    sale_price DECIMAL(12,2) NOT NULL,
    commission_amount DECIMAL(10,2),
    transaction_date DATE DEFAULT (CURRENT_DATE),
    transaction_type ENUM('Sale', 'Rent') NOT NULL,
    payment_method ENUM('Cash', 'Loan', 'Installment') DEFAULT 'Loan',
    FOREIGN KEY (property_id) REFERENCES Properties(property_id),
    FOREIGN KEY (buyer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (seller_id) REFERENCES Owners(owner_id),
    FOREIGN KEY (agent_id) REFERENCES Agents(agent_id)
);

-- 7. PROPERTY_FEATURES TABLE
CREATE TABLE Property_Features (
    feature_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    feature_name VARCHAR(100) NOT NULL,
    feature_value VARCHAR(255),
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- 8. PROPERTY_IMAGES TABLE
CREATE TABLE Property_Images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_description VARCHAR(255),
    upload_date DATE DEFAULT (CURRENT_DATE),
    is_primary BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- 9. PROPERTY_MAINTENANCE TABLE
CREATE TABLE Property_Maintenance (
    maintenance_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    description TEXT NOT NULL,
    maintenance_date DATE NOT NULL,
    cost DECIMAL(10,2),
    status ENUM('Pending', 'In Progress', 'Completed') DEFAULT 'Pending',
    contractor_name VARCHAR(100),
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- 10. OFFERS TABLE
CREATE TABLE Offers (
    offer_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    customer_id INT NOT NULL,
    offer_amount DECIMAL(12,2) NOT NULL,
    offer_date DATE DEFAULT (CURRENT_DATE),
    status ENUM('Pending', 'Accepted', 'Rejected') DEFAULT 'Pending',
    notes TEXT,
    FOREIGN KEY (property_id) REFERENCES Properties(property_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

-- 11. PROPERTY_DOCUMENTS TABLE
CREATE TABLE Property_Documents (
    document_id INT PRIMARY KEY AUTO_INCREMENT,
    property_id INT NOT NULL,
    document_type ENUM('Title', 'Deed', 'Survey', 'Tax Record', 'Other') NOT NULL,
    document_url VARCHAR(255) NOT NULL,
    upload_date DATE DEFAULT (CURRENT_DATE),
    description TEXT,
    FOREIGN KEY (property_id) REFERENCES Properties(property_id)
);

-- ===============================================
-- SAMPLE DATA INSERTION
-- ===============================================

-- Insert Agents
INSERT INTO Agents (name, phone, email, commission_rate, hire_date, experience_years) VALUES
('John Smith', '123-456-7890', 'john.smith@realestate.com', 3.0, '2020-01-15', 4),
('Sarah Johnson', '234-567-8901', 'sarah.j@realestate.com', 2.5, '2021-03-20', 3),
('Mike Davis', '345-678-9012', 'mike.davis@realestate.com', 2.8, '2019-06-10', 5),
('Lisa Brown', '456-789-0123', 'lisa.brown@realestate.com', 3.2, '2022-01-05', 2),
('David Wilson', '567-890-1234', 'david.wilson@realestate.com', 2.7, '2020-09-12', 4);

-- Insert Owners
INSERT INTO Owners (name, phone, email, address) VALUES
('Robert Anderson', '111-222-3333', 'robert.a@email.com', '123 Oak Street, Downtown'),
('Maria Garcia', '222-333-4444', 'maria.garcia@email.com', '456 Pine Avenue, Suburbs'),
('James Taylor', '333-444-5555', 'james.taylor@email.com', '789 Maple Drive, Uptown'),
('Jennifer Lee', '444-555-6666', 'jennifer.lee@email.com', '321 Elm Street, Midtown'),
('Michael Chen', '555-666-7777', 'michael.chen@email.com', '654 Cedar Lane, Downtown');

-- Insert Customers
INSERT INTO Customers (name, phone, email, budget_min, budget_max, preferred_location, customer_type) VALUES
('Emily White', '777-888-9999', 'emily.white@email.com', 200000, 350000, 'Downtown', 'Buyer'),
('Daniel Green', '888-999-0000', 'daniel.green@email.com', 150000, 250000, 'Suburbs', 'Buyer'),
('Amanda Black', '999-000-1111', 'amanda.black@email.com', 1500, 2500, 'Uptown', 'Renter'),
('Kevin Blue', '000-111-2222', 'kevin.blue@email.com', 300000, 500000, 'Downtown', 'Buyer'),
('Rachel Red', '111-222-3333', 'rachel.red@email.com', 2000, 3000, 'Midtown', 'Renter');

-- Insert Properties
INSERT INTO Properties (owner_id, agent_id, address, city, state, property_type, bedrooms, bathrooms, area_sqft, price, description) VALUES
(1, 1, '100 Main Street', 'New York', 'NY', 'House', 3, 2, 1500.00, 320000.00, 'Beautiful family home with garden'),
(2, 2, '200 Broadway Ave', 'New York', 'NY', 'Apartment', 2, 1, 900.00, 180000.00, 'Modern apartment in prime location'),
(3, 1, '300 Park Place', 'New York', 'NY', 'House', 4, 3, 2200.00, 450000.00, 'Luxury home with pool and garage'),
(4, 3, '400 Fifth Avenue', 'New York', 'NY', 'Commercial', 0, 2, 3000.00, 750000.00, 'Prime commercial space downtown'),
(5, 2, '500 Central Park', 'New York', 'NY', 'Apartment', 1, 1, 600.00, 120000.00, 'Cozy studio comercian'),
(1, 4, '600 Wall Street', 'New York', 'NY', 'House', 5, 4, 2800.00, 680000.00, 'Executive mansion with city view'),
(2, 5, '700 Madison Ave', 'New York', 'NY', 'Apartment', 3, 2, 1200.00, 280000.00, 'Spacious family apartment');

-- Insert Property Viewings
INSERT INTO Property_Viewings (property_id, customer_id, agent_id, viewing_date, feedback, rating, interested) VALUES
(1, 1, 1, '2024-06-01 10:00:00', 'Great location, perfect size for family', 5, 'Yes'),
(2, 2, 2, '2024-06-02 14:30:00', 'Nice apartment but a bit small', 4, 'Maybe'),
(3, 4, 1, '2024-06-03 16:00:00', 'Excellent property, exactly what I need', 5, 'Yes'),
(1, 2, 1, '2024-06-04 11:00:00', 'Good house but over budget', 3, 'No'),
(5, 3, 2, '2024-06-05 15:00:00', 'Perfect for renting, great location', 4, 'Yes'),
(7, 5, 5, '2024-06-06 13:00:00', 'Love the space and amenities', 5, 'Yes'),
(2, 1, 2, '2024-06-07 10:30:00', 'Too small for our needs', 2, 'No');

-- Insert Transactions
INSERT INTO Transactions (property_id, buyer_id, seller_id, agent_id, sale_price, commission_amount, transaction_type, payment_method) VALUES
(1, 1, 1, 1, 320000.00, 9600.00, 'Sale', 'Loan'),
(3, 4, 3, 1, 450000.00, 13500.00, 'Sale', 'Cash'),
(5, 3, 5, 2, 1800.00, 45.00, 'Rent', 'Cash'),
(7, 5, 2, 5, 2200.00, 59.40, 'Rent', 'Cash');

-- Insert Property Features
INSERT INTO Property_Features (property_id, feature_name, feature_value) VALUES
(1, 'Parking', '2-car garage'),
(1, 'Heating', 'Central'),
(2, 'View', 'City view'),
(3, 'Pool', 'Private pool');

-- Insert Property Images
INSERT INTO Property_Images (property_id, image_url, image_description, is_primary) VALUES
(1, 'images/prop1_main.jpg', 'Main facade', TRUE),
(1, 'images/prop1_interior.jpg', 'Living room', FALSE),
(2, 'images/prop2_main.jpg', 'Apartment exterior', TRUE);

-- Insert Property Maintenance
INSERT INTO Property_Maintenance (property_id, description, maintenance_date, cost, status, contractor_name) VALUES
(1, 'Roof repair', '2024-05-15', 5000.00, 'Completed', 'ABC Contractors'),
(2, 'HVAC maintenance', '2024-06-01', 800.00, 'In Progress', 'XYZ Services');

-- Insert Offers
INSERT INTO Offers (property_id, customer_id, offer_amount, notes) VALUES
(2, 1, 170000.00, 'Initial offer pending inspection'),
(3, 4, 430000.00, 'Cash offer');

-- Insert Property Documents
INSERT INTO Property_Documents (property_id, document_type, document_url, description) VALUES
(1, 'Title', 'docs/prop1_title.pdf', 'Property title document'),
(1, 'Survey', 'docs/prop1_survey.pdf', 'Land survey');

-- Update property status after transactions
UPDATE Properties SET status = 'Sold' WHERE property_id IN (1, 3);
UPDATE Properties SET status = 'Rented' WHERE property_id IN (5, 7);