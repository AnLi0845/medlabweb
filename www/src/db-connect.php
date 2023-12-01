<?php
// Database credentials
$host = 'medlab-db';  // or your database host
$dbname = 'Medlab';   // your database name
$user = 'MedLabWeb';   // your database username
$password = 'password'; // your database password

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Uncomment the below line to display a success message
#echo "Connected successfully";

// Remember to close the connection when done, by using $conn->close(); 
// Usually, this is done at the end of your script that uses the database.
?>