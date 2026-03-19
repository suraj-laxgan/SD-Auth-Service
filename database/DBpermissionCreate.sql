-- Auth service
CREATE DATABASE auth_db;
CREATE USER 'auth_user'@'%' IDENTIFIED BY 'auth_pass';
GRANT ALL PRIVILEGES ON auth_db.* TO 'auth_user'@'%';

-- Payment service
CREATE DATABASE payment_db;
CREATE USER 'payment_user'@'%' IDENTIFIED BY 'pay_pass';
GRANT ALL PRIVILEGES ON payment_db.* TO 'payment_user'@'%';