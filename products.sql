CREATE TABLE products (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    product_code VARCHAR(50) NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    product_description TEXT NOT NULL,
    product_price DECIMAL(10,2) NOT NULL,
    product_quantity INT(11) NOT NULL,
    product_image VARCHAR(255) NOT NULL
);