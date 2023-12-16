SELECT customer.name
FROM customer
LEFT JOIN medication ON customer.customer_username = medication.customer_username
WHERE medication.customer_username IS NULL;






