SELECT name, diet_plan_type, activity_plan_type, date_of_birth FROM (
    SELECT name, customer_username, date_of_birth FROM customer
    WHERE date_of_birth > '2005-01-01'
) AS filtered_customer
JOIN plan ON filtered_customer.customer_username = plan.customer_username
JOIN diet_plan ON plan.plan_id = diet_plan.plan_id
JOIN activity_plan ON plan.plan_id = activity_plan.plan_id;
