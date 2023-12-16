SELECT * FROM (
    SELECT customer_username AS username, password FROM customer
    UNION
    SELECT employee_username AS username, password FROM employee
) AS combined_table
WHERE username = 'kostasan' AND password = 'edewe3';
