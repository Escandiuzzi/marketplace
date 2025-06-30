CREATE TABLE clients (
    id SERIAL PRIMARY KEY,
    number VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    -- Address Info
    street VARCHAR(255),
    address_number VARCHAR(20),
    complement VARCHAR(100),
    neighborhood VARCHAR(100),
    city VARCHAR(100),
    state VARCHAR(100),
    zip VARCHAR(20),

    -- Payment Info
    card_number VARCHAR(25),
    expiration_date VARCHAR(10),
    cvv VARCHAR(10),
    holder_name VARCHAR(255)
);

CREATE TABLE admins (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE suppliers (
    id SERIAL PRIMARY KEY,
    number INTEGER NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT,

    -- Address Info
    street VARCHAR(255),
    address_number VARCHAR(20),
    complement VARCHAR(100),
    neighborhood VARCHAR(100),
    city VARCHAR(100),
    state VARCHAR(100),
    zip VARCHAR(20)
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,
    supplier_id INT,
    image BYTEA,
    CONSTRAINT fk_supplier
        FOREIGN KEY (supplier_id)
        REFERENCES suppliers(id)
        ON DELETE SET NULL
);

INSERT INTO products (name, description, price, quantity, supplier_id, image) VALUES
('Product A', 'Description for Product A', 10.00, 100, 1, NULL),
('Product B', 'Description for Product B', 20.00, 50, 2, NULL),
('Product C', 'Description for Product C', 30.00, 200, 3, NULL);


INSERT INTO admins (name, email, password) VALUES
('Admin User', 'admin', MD5('admin'));

INSERT INTO suppliers (number, name, description, street, address_number, complement, neighborhood, city, state, zip) VALUES
(88888888, 'Supplier One', 'Description for Supplier One', '123 Main St', '1A', 'Apt 101', 'Downtown', 'Cityville', 'State', '12345-678'),
(88888887, 'Supplier Two', 'Description for Supplier Two', '456 Elm St', '2B', '', 'Uptown', 'Townsville', 'State', '23456-789'),
(888888886, 'Supplier Three', 'Description for Supplier Three', '789 Oak St', '', '', 'Suburbia', 'Villageville', 'State', '34567-890');

