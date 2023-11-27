<?php
session_start();

include 'db-connect.php';

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Assuming the logged-in user's ID is stored in session
$patientId = $_SESSION['patient_id']; // Replace 'patient_id' with the actual session variable name

// SQL query to fetch user information
$sql = "SELECT First_Name, Last_Name, DATE_FORMAT(Date_of_Birth, '%d-%m-%Y') as Date_of_Birth, Email, Phone_Number, Address 
        FROM Patients 
        WHERE Patient_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patientId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Display user information
    echo "<h2>User Profile</h2>";
    echo "Name: " . $user["First_Name"] . " " . $user["Last_Name"] . "<br>";
    echo "Date of Birth: " . $user["Date_of_Birth"] . "<br>";
    echo "Email: " . $user["Email"] . "<br>"; // Consider decrypting if encrypted
    echo "Phone: " . $user["Phone_Number"] . "<br>"; // Consider decrypting if encrypted
    echo "Address: " . $user["Address"] . "<br>"; // Consider decrypting if encrypted
} else {
    echo "User information not found.";
}

$conn->close();
?>
