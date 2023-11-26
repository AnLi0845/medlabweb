<?php
session_start();

// Include the database connection
include 'db-connect.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    // Sanitize and validate inputs
    $username = trim($conn->real_escape_string($_POST['username']));
    $password = trim($_POST['password']);
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';

    // Basic validation
    if (empty($username) || empty($password)) {
        // Handle error - empty fields
        // Redirect back to login page with an error message
        header("Location: index.php");
        exit();
    }

    // Determine the table to query based on the role
    $table = ($role === 'staff') ? 'staff' : 'patients';

    // Prepare statement for database query
    $stmt = $conn->prepare("SELECT Password, Salt FROM $table WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $salt = $user['Salt']; // Assuming 'salt' is the field name for the salt

            // Hash the submitted password with the salt
            $hashedPassword = hash('sha256', $password . $salt);

            // Compare the hashed password with the one stored in the database
            if ($hashedPassword == $user['Password']) {
                // Password is correct, set the session variables
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Redirect to a different page based on the role
                header("Location: Dashboard.php");
                exit();
            } else {
                // Handle error - invalid password
                header("Location: login.php?error=invalidpassword");
                exit();
            }
        } else {
            // Handle error - invalid username
            header("Location: login.php?error=invalidusername");
            exit();
        }
    } else {
        // Handle SQL execution error
        header("Location: login.php?error=sqlexecutionerror");
        exit();
    }
    $stmt->close();
} else {
    // Redirect to login form if accessed directly or invalid form submission
    header("Location: login.php?error=invalidaccess");
    exit();
}

// Close the database connection
$conn->close();
?>
