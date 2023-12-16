SELECT customer.name, customer_meets_employee.appointment_date, diet_plan.diet_plan_type
FROM customer
JOIN plan ON customer.customer_username = plan.customer_username
JOIN diet_plan ON plan.plan_id = diet_plan.plan_id
JOIN customer_meets_employee ON customer.customer_username = customer_meets_employee.customer_username
WHERE customer_meets_employee.appointment_date = '2023-01-10 18:00:00';
