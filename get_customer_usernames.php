<?php
include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT c.customer_username, c.name 
        FROM plan p
        JOIN customer c ON p.customer_username = c.customer_username";

$result = $conn->query($sql);

$customerData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customerData[] = array(
            'customer_username' => $row['customer_username'],
            'name' => $row['name']
        );
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($customerData);
?>
