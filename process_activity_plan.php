<?php
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $customer_username = $_POST['customer_username'];
    $plan_id = intval(microtime(true)/1000) + rand(); 
    
    $sql = "INSERT INTO plan (plan_id, start_date, end_date, customer_username) VALUES ('$plan_id', '$start_date', '$end_date', '$customer_username')";    

    if ($conn->query($sql) === TRUE) {
        $activity_type = $_POST['activity_type'];
        $duration = $_POST['duration'];
        $activity_date = $_POST['activity_date'];

        // Insert data into the activity table first
        $activity_id = intval(microtime(true)/1000) + rand(); 

        $sql = "INSERT INTO activity (activity_type, duration, activity_date, activity_id) VALUES
                                ('$activity_type', '$duration', '$activity_date', '$activity_id')";
        
        if ($conn->query($sql) === TRUE) {
        $activity_plan_type = $_POST['activity_plan_type'];

            // Now, insert data into the activity_plan table
            $sql = "INSERT INTO activity_plan (activity_plan_type, activity_id, plan_id) VALUES 
                                                ('$activity_plan_type', '$activity_id', '$plan_id')";
    
            if ($conn->query($sql) === TRUE) {
                // Data successfully inserted
                // echo "Data inserted successfully!";
            } else {
                echo "Error inserting data into activity_plan: " . $conn->error;
            }
        } else {
            echo "Error inserting data into activity: " . $conn->error;
        }
    } else {
        echo "Error inserting data into plan: " . $conn->error;
    }
}
$conn->close();
?>
