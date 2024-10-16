CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY, 
    company_name VARCHAR(255) NOT NULL,          
    address VARCHAR(255),                        
    phone_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
