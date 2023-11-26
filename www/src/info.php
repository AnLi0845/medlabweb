<?php
session_start();

include 'db-connect.php';

// Assuming the logged-in user's ID is stored in session
$patientId = $_SESSION['patient_id'];

// SQL query to fetch order details
$sql = "SELECT o.Order_ID, tc.Test_Name, s.First_Name as Physician_First_Name, s.Last_Name as Physician_Last_Name, b.Billed_Amount, o.Status FROM Orders o JOIN Tests_Catalog tc ON o.Test_Code = tc.Test_Code JOIN Staff s ON o.Ordering_Physician = s.Staff_ID JOIN Billing b ON o.Order_ID = b.Order_ID WHERE o.Patient_ID = ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientId);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are orders
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row["Order_ID"]. " - Test Name: " . $row["Test_Name"]. " - Physician: " . $row["Physician_First_Name"]. " " . $row["Physician_Last_Name"]. " - Billed Amount: " . $row["Billed_Amount"]. " - Status: " . $row["Status"]. "<br>";
    }
} else {
    echo "No orders found";
}
$conn->close();
?>
