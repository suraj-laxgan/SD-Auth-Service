-- Auth service
    -- Read and wright
    CREATE DATABASE auth_db;
    CREATE USER 'auth_user'@'%' IDENTIFIED BY 'auth_pass';
    GRANT ALL PRIVILEGES ON auth_db.* TO 'auth_user'@'%';

    -- Read Only
    CREATE USER 'auth_readonly'@'%' IDENTIFIED BY 'readonly_pass';
    GRANT SELECT ON auth_db.* TO 'auth_readonly'@'%';
    FLUSH PRIVILEGES;



    -- If you want even tighter security:
    GRANT SELECT, SHOW VIEW ON auth_db.* TO 'auth_readonly'@'%';
     -- Specific permissions
    GRANT SELECT, INSERT, UPDATE ON auth_db.* TO 'limited_user'@'%';

    -- 1. List all users
        SELECT User, Host FROM mysql.user;
    -- 2 want to check your current logged-in user permissions:
        SHOW GRANTS;
    -- 3 check user permissions:
        SHOW GRANTS FOR 'auth_user'@'%';
   
    -- 4 Database-level permissions:
        SELECT * FROM mysql.db WHERE User = 'auth_user';
    -- 5 Table-level permissions:
        SELECT * FROM mysql.tables_priv  WHERE User = 'auth_user';
    -- 6 Remove / Revoke permission
        REVOKE ALL PRIVILEGES ON auth_db.* FROM 'user1'@'%';
    -- 7 Delete user
        DROP USER 'user1'@'%';
    -- 8 Refresh Privileges
        FLUSH PRIVILEGES;

    -- 9 Host-Based Access Control
        CREATE USER 'user1'@'localhost' IDENTIFIED BY 'pass';
    -- 10 Check DB-level Access
        SELECT * FROM mysql.db WHERE Db='auth_db';
    -- Change root password
        ALTER USER 'root'@'localhost' IDENTIFIED BY 'rootpass';
    -- Apply changes
        FLUSH PRIVILEGES;


-- Payment service
CREATE DATABASE payment_db;
CREATE USER 'payment_user'@'%' IDENTIFIED BY 'pay_pass';
GRANT ALL PRIVILEGES ON payment_db.* TO 'payment_user'@'%';