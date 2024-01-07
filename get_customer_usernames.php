<?php
// Establish a connection to the MySQL database (replace with your credentials)
include 'db_connection.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customer_usernames from the 'plan' table
$sql = "SELECT DISTINCT customer_username FROM plan";
$result = $conn->query($sql);

$customerUsernames = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customerUsernames[] = $row['customer_username'];
    }
}

$conn->close();

// Return JSON-encoded array
echo json_encode($customerUsernames);
?>
