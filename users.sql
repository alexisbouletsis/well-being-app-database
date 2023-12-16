CREATE USER 'admin'@'localhost' IDENTIFIED BY 'adminpassword';
GRANT ALL PRIVILEGES ON `well-being_app_db`.* TO 'admin'@'localhost';


CREATE USER 'employee'@'localhost' IDENTIFIED BY 'employeepassword';
GRANT SELECT (customer_username, name, email, date_of_birth, gender) ON `well-being_app_db`.customer TO 'employee'@'localhost';
GRANT SELECT ON `well-being_app_db`.biometrics TO 'employee'@'localhost';
GRANT SELECT ON `well-being_app_db`.medication TO 'employee'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, ALTER ON `well-being_app_db`.activity TO 'employee'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, ALTER ON `well-being_app_db`.activity_plan TO 'employee'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, ALTER ON `well-being_app_db`.customer_meets_employee TO 'employee'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, ALTER ON `well-being_app_db`.diet_plan TO 'employee'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, ALTER ON `well-being_app_db`.meal TO 'employee'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE, ALTER ON `well-being_app_db`.plan TO 'employee'@'localhost';
GRANT INSERT, UPDATE ON `well-being_app_db`.employee TO 'employee'@'localhost';


CREATE USER 'customer'@'%' IDENTIFIED BY 'customerpassword';
GRANT INSERT, UPDATE ON `well-being_app_db`.customer TO 'customer'@'%';
GRANT SELECT, DELETE, INSERT, UPDATE ON `well-being_app_db`.biometrics TO 'customer'@'%';
GRANT SELECT, DELETE, INSERT, UPDATE ON `well-being_app_db`.medication TO 'customer'@'%';
GRANT SELECT ON `well-being_app_db`.diet_plan TO 'customer'@'%';
GRANT SELECT ON `well-being_app_db`.activity_plan TO 'customer'@'%';
GRANT SELECT ON `well-being_app_db`.customer_meets_employee TO 'customer'@'%';
