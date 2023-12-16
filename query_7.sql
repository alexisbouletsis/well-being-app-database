SELECT customer.name, filtered_plan.plan_id
FROM customer
JOIN (
    SELECT plan.plan_id, plan.customer_username
    FROM plan
    JOIN plan AS P2 ON 
        plan.start_date != P2.start_date AND 
        plan.end_date != P2.end_date AND 
        plan.plan_id != P2.plan_id AND 
        plan.customer_username = P2.customer_username
) AS filtered_plan ON filtered_plan.customer_username = customer.customer_username;
