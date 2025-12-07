## SQL Queries for address, orders and items


```php
CREATE TABLE address(
    address_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address_type VARCHAR(10) DEFAULT 'home',
    street_address VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    province VARCHAR(255) NOT NULL,
    postal_code VARCHAR(10)NOT NULL,
    is_default BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    INDEX idx_user_address(user_id)
);

CREATE TABLE orders(
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address_id INT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_amount DECIMAL(10, 2) NOT NULL CHECK (total_amount >= 0),
    status VARCHAR(100) DEFAULT 'pending',
    payment_method VARCHAR(100) DEFAULT 'cash_on_delivery',
    payment_status VARCHAR(15) DEFAULT 'unpaid',
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (address_id) REFERENCES addresses(address_id),
    INDEX idx_user_orders (user_id),
    INDEX idx_order_date (order_date),
    INDEX idx_status (status),
    INDEX idx_total_amount (total_amount)

);


```