<?php
session_start();

include 'db-connect.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Get the order ID from URL parameter
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

// SQL query to fetch detailed order information
$sql = "SELECT tc.Test_Name, CONCAT(s.First_Name, ' ', s.Last_Name) as Physician_Name, o.Order_Date, o.Status, 
               b.Billed_Amount, b.Payment_Status, b.Insurance_Claim_Status, r.Report_URL, 
               CONCAT(p.First_Name, ' ', p.Last_Name) as Pathologist_Name
        FROM Orders o
        JOIN Tests_Catalog tc ON o.Test_Code = tc.Test_Code
        JOIN Staff s ON o.Ordering_Physician = s.Staff_ID
        JOIN Billing b ON o.Order_ID = b.Order_ID
        LEFT JOIN Results r ON o.Order_ID = r.Order_ID
        LEFT JOIN Staff p ON r.Reporting_Pathologist = p.Staff_ID
        WHERE o.Order_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Display each field in the order
        echo "Test Name: " . $row["Test_Name"] . "<br>";
        echo "Ordering Physician: " . $row["Physician_Name"] . "<br>";
        // ... Display other fields ...
    }
} else {
    echo "No detailed information found for this order.";
}

$conn->close();
?>