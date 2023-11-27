<?php
include 'db-connect.php';

$username = $_SESSION['username']; // Assuming username is stored in session

// Fetch basic user information
$basicInfoQuery = "SELECT First_Name, Last_Name, DATE_FORMAT(Date_of_Birth, '%d-%m-%Y') as Date_of_Birth FROM Patients WHERE Username = ?";
$stmt = $conn->prepare($basicInfoQuery);
$stmt->bind_param("s", $username);
$stmt->execute();
$basicResult = $stmt->get_result();

if ($basicResult->num_rows > 0) {
    $basicInfo = $basicResult->fetch_assoc();

    // Display basic user information
    echo "<h2>User Profile</h2>";
    echo "Name: " . $basicInfo["First_Name"] . " " . $basicInfo["Last_Name"] . "<br>";
    echo "Date of Birth: " . $basicInfo["Date_of_Birth"] . "<br>";
} else {
    echo "User information not found.";
}

// Prepare the call to the stored procedure for encrypted data
$encDataQuery = "CALL DecryptPatientInfo(?)";
$encStmt = $conn->prepare($encDataQuery);
$encStmt->bind_param("s", $username);
$encStmt->execute();
$encResult = $encStmt->get_result();

if ($encResult->num_rows > 0) {
    $decryptedInfo = $encResult->fetch_assoc();

    // Display decrypted information
    echo "Email: " . $decryptedInfo["Email"] . "<br>";
    echo "Phone: " . $decryptedInfo["Phone_Number"] . "<br>";
    echo "Address: " . $decryptedInfo["Address"] . "<br>";
} else {
    echo "Decrypted information not found.";
}

$conn->close();
?>
