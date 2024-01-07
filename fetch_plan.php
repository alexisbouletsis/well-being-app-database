<?php
// Establish a connection to the MySQL database (replace with your credentials)
include 'db_connection.php';

// Get the posted data
// $postData = json_decode(file_get_contents("php://input"));

// Extract selected date and customer from the posted data
$selectedDate = $_POST['selectedDate'];
$selectedCustomer = $_POST['selectedCustomer'];

// Fetch data from the database based on the selected date and customer


$sql_1 = "SELECT p.plan_id
        FROM 
            plan p
        JOIN 
            activity_plan ap ON p.plan_id = ap.plan_id
        JOIN 
            activity a ON ap.activity_id = a.activity_id
        JOIN 
            diet_plan dp ON p.plan_id = dp.plan_id
        JOIN 
            meal m ON dp.meal_id = m.meal_id
        WHERE 
            p.customer_username = '$selectedCustomer'
            AND 
            (a.activity_date = '$selectedDate'
            OR m.meal_date = '$selectedDate')";

$result_1 = $conn->query($sql_1);

if ($result_1->num_rows > 0) {
    $row_1 = $result_1->fetch_assoc();
    $planID = $row_1["plan_id"];

    $sql_2  = "SELECT *
                FROM plan p
                JOIN diet_plan dp ON p.plan_id = dp.plan_id
                JOIN meal m ON dp.meal_id = m.meal_id
                WHERE p.plan_id = '$planID'
                AND m.meal_date = '$selectedDate'";

    $result_2 = $conn->query($sql_2);

    $data = array();

    if ($result_2->num_rows > 0) {
        // Initialize an array to store meal names
        $mealNames = array();
    
        // Iterate through the result set
        while ($row = $result_2->fetch_assoc()) {
            // Store each meal name in the array
            $mealNames[] = $row["meal_name"];
            $dietPlanTypes[] = $row["diet_plan_type"];
            $calories[] = $row["calories"];
            $type[] = $row["type"];
            $proteins[] = $row["proteins"];
            $carbs[] = $row["carbs"];
            $fat[] = $row["fat"];
        }
    
        // Assign the array of meal names to the 'mealName' key in the $data array
        $data['mealName'] = $mealNames;
        $data['dietPlanType'] = $dietPlanTypes;
        $data['calories'] = $calories;
        $data['type'] = $type;
        $data['proteins'] = $proteins;
        $data['carbs'] = $carbs;
        $data['fat'] = $fat;

    } else {
        $data['mealName'] = '-';
        $data['dietPlanType'] = '-';
        $data['calories'] = '-';
        $data['type'] = '-';
        $data['proteins'] = '-';
        $data['carbs'] = '-';
        $data['fat'] = '-';
        
    }


    $sql_3  = "SELECT *
                FROM plan p
                JOIN activity_plan ap ON p.plan_id = ap.plan_id
                JOIN activity act ON ap.activity_id = act.activity_id
                WHERE p.plan_id = '$planID'
                AND act.activity_date = '$selectedDate'";

    $result_3 = $conn->query($sql_3);

    if ($result_3->num_rows > 0) {
        $row = $result_3->fetch_assoc();
        $data['activityPlanType'] = $row["activity_plan_type"];
        $data['activityType'] = $row["activity_type"];
        $data['duration'] = $row["duration"];
    }
    else {
        $data['activityPlanType'] = '-';
        $data['activityType'] = '-';
        $data['duration'] = '-';
    }
}
else {
    $data['mealName'] = '-';
    $data['dietPlanType'] = '-';
    $data['calories'] = '-';
    $data['type'] = '-';
    $data['proteins'] = '-';
    $data['carbs'] = '-';
    $data['fat'] = '-';
    $data['activityPlanType'] = '-';
    $data['activityType'] = '-';
    $data['duration'] = '-';
}



$conn->close();

// Return the data as JSON
echo json_encode($data);
?>
