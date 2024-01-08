<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $customer_username = $_POST['customer_username'];
    $plan_id = intval(microtime(true)/1000) + rand(); 
    
    $sql = "INSERT INTO plan (plan_id, start_date, end_date, customer_username) VALUES ('$plan_id', '$start_date', '$end_date', '$customer_username')";    

    if ($conn->query($sql) === TRUE) {
        // Insert data into the meal table first
        $meal_name = $_POST['meal_name'];
        $calories = $_POST['calories'];
        $type = $_POST['type'];
        $proteins = $_POST['proteins'];
        $carbs = $_POST['carbs'];
        $fat = $_POST['fat'];
        $meal_date = $_POST['meal_date'];
        $meal_id = intval(microtime(true)/1000) + rand(); 

        $sql = "INSERT INTO meal (meal_name, calories, type, proteins, carbs, fat, meal_date, meal_id) VALUES
                                ('$meal_name', '$calories', '$type', '$proteins', '$carbs', '$fat', '$meal_date', '$meal_id')";
        
        if ($conn->query($sql) === TRUE) {
            $diet_plan_type = $_POST['diet_plan_type'];
            // Now, insert data into the diet_plan table
            $sql = "INSERT INTO diet_plan (diet_plan_type, meal_id, plan_id) VALUES ('$diet_plan_type', '$meal_id', '$plan_id')";
    
            if ($conn->query($sql) === TRUE) {
                // Data successfully inserted
                // echo "Data inserted successfully!";
            } else {
                echo "Error inserting data into diet_plan: " . $conn->error;
            }
        } else {
            echo "Error inserting data into meal: " . $conn->error;
        }
    } else {
        echo "Error inserting data into plan: " . $conn->error;
    }
}
$conn->close();
?>
