SELECT weight, height, measurement_date, name FROM (
    SELECT weight, height, measurement_date, customer_username FROM BIOMETRICS
    WHERE weight / (height * height) > 18.5 AND weight / (height * height) < 25
) AS filtered_biometrics
JOIN customer ON filtered_biometrics.customer_username = CUSTOMER.customer_username;
