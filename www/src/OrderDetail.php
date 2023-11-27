<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
// Assuming the logged-in user's ID is stored in session
$patientId = $_SESSION['patient_id']; // Replace 'patient_id' with the actual session variable name

// Get the order ID from URL parameter
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
include 'db-connect.php';
// Verify that the order belongs to the logged-in user
$orderCheckQuery = "SELECT Patient_ID FROM Orders WHERE Order_ID = ?";
$orderCheckStmt = $conn->prepare($orderCheckQuery);
$orderCheckStmt->bind_param("i", $order_id);
$orderCheckStmt->execute();
$orderCheckResult = $orderCheckStmt->get_result();

if ($orderCheckResult->num_rows > 0) {
    $orderData = $orderCheckResult->fetch_assoc();
    if ($orderData['Patient_ID'] != $patientId) {
        // Order does not belong to the user
        header('Location: Dashboard2.php');
        exit;
    }
} else {
    // Order not found
    echo "Order not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="/dist/output.css" rel="stylesheet">
</head>

<body>
    <!-- component -->
    <style>
        :root {
            font-family: 'Inter', sans-serif;
        }

        @supports (font-variation-settings: normal) {
            :root {
                font-family: 'Inter var', sans-serif;
            }
        }
    </style>


    <div class="antialiased bg-black w-full min-h-screen text-slate-300 relative py-4">
        <div class="grid grid-cols-12 mx-auto gap-2 sm:gap-4 md:gap-6 lg:gap-10 xl:gap-14 max-w-7xl my-10 px-2">
            <div id="menu" class="bg-white/10 col-span-3 rounded-lg p-4 ">
                <h1 class="font-bold text-lg lg:text-3xl bg-gradient-to-br from-white bg-clip-text">
                    MedLab<span class="text-indigo-400"></span></h1>
                <p class="text-slate-400 text-sm mb-2">Welcome back</p>
                <a href="Dashboard2.php"
                    class="flex flex-col space-y-2 md:space-y-0 md:flex-row mb-5 items-center md:space-x-2 hover:bg-white/10 group transition duration-150 ease-linear rounded-lg group w-full py-3 px-2">
                    <div>
                        <img class="rounded-full w-10 h-10 relative object-cover"
                            src="istockphoto-1337144146-612x612.jpg" alt="">
                    </div>
                    <div>
                        <p class="font-medium group-hover:text-indigo-400 leading-4">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </p>
                        <span class="text-xs text-slate-400">
                            <?php echo htmlspecialchars($_SESSION['role']); ?>
                        </span>
                    </div>
                </a>
                <hr class="my-2 border-slate-700">
                <div id="menu" class="flex flex-col space-y-2 my-5">
                    <a href="Dashboard2.php"
                        class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                        <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                            <div>
                                <p
                                    class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-indigo-400">
                                    Dashboard</p>
                                <p class="text-slate-400 text-sm hidden md:block">Return to Dashboard</p>
                            </div>

                        </div>
                    </a>
                </div>
                <div id="menu" class="flex flex-col space-y-2 my-5">
                    <a href="logout.php"
                        class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                        <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">

                            <div>
                                <p
                                    class="font-bold text-base lg:text-lg text-slate-200 leading-4 group-hover:text-indigo-400">
                                    Log out</p>
                                <p class="text-slate-400 text-sm hidden md:block">Return to the login page</p>
                            </div>

                        </div>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div id="content" class="bg-white/10 col-span-9 rounded-lg p-6">
                <div id="Order">
                    <h1 class="font-bold py-4 uppercase">Order Details</h1>
                    <div class="overflow-x-scroll">

                        <!-- component -->
                        <div class="min-h-screen flex justify-center px-4">
                            <?php
                            include 'db-connect.php';

                            // Check if the user is logged in
                            if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
                                header("Location: login.php");
                                exit;
                            }

                            // Get the order ID from URL parameter
                            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

                            // SQL query to fetch detailed order information
                            $sql = "SELECT tc.Test_Name, tc.Description, CONCAT(s.First_Name, ' ', s.Last_Name) as Physician_Name, o.Order_Date, o.Status, b.Billed_Amount, b.Payment_Status, b.Insurance_Claim_Status, r.Report_URL, CONCAT(p.First_Name, ' ', p.Last_Name) as Pathologist_Name FROM Orders o JOIN Tests_Catalog tc ON o.Test_Code = tc.Test_Code JOIN Staff s ON o.Ordering_Physician = s.Staff_ID JOIN Billing b ON o.Order_ID = b.Order_ID LEFT JOIN Results r ON o.Order_ID = r.Order_ID LEFT JOIN Staff p ON r.Reporting_Pathologist = p.Staff_ID WHERE o.Order_ID = ?";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("i", $order_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Display each field in the order
                                    echo '<div class="max-w-4xl  bg-white w-full rounded-lg shadow-xl">
                                    <div class="p-4 border-b">
                                        <h2 class="text-2xl text-gray-500">
                                        ' . $row["Test_Name"] . '
                                        </h2>
                                        <p class="text-sm text-gray-500">
                                            ' . $row["Description"] . '
                                        </p>
                                    </div>
                                    <div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                                Physician name
                                            </p>
                                            <p class="text-gray-500">
                                            ' . $row["Physician_Name"] . '
                                            </p>
                                        </div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                                Pathologist Name
                                            </p>
                                            <p class="text-gray-500">
                                            ';
                                    if (!empty($row["Pathologist_Name"])) {
                                        echo $row["Pathologist_Name"];
                                    } else {
                                        echo " Not Available<br>";
                                    }
                                    echo '
                                            </p>
                                        </div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                                Order Date
                                            </p>
                                            <p class="text-gray-500">
                                            ' . $row["Order_Date"] . '
                                            </p>
                                        </div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                                Order Status
                                            </p>
                                            <p class="text-gray-500">
                                            ' . $row["Status"] . '
                                            </p>
                                        </div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                                Billing Amount
                                            </p>
                                            <p class="text-gray-500">
                                            $' . $row["Billed_Amount"] . '
                                            </p>
                                        </div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                                Billing Status
                                            </p>
                                            <p class="text-gray-500">
                                            ' . $row["Payment_Status"] . '
                                            </p>
                                        </div>
                                        <div
                                            class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4 border-b">
                                            <p class="text-gray-600">
                                            Insurance Claim Status
                                            </p>
                                            <p class="text-gray-500">
                                            ' . $row["Insurance_Claim_Status"] . '
                                            </p>
                                        </div>
                                        <div class="md:grid md:grid-cols-2 hover:bg-gray-50 md:space-y-0 space-y-1 p-4">
                                            <p class="text-gray-600">
                                                Test Result
                                            </p>
                                            <div class="space-y-2">
                                                <div
                                                    class="border-2 flex items-center p-2 rounded justify-between space-x-2">
                                                    <div class="space-x-2 truncate">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="fill-current inline text-gray-500" width="24" height="24"
                                                            viewBox="0 0 24 24">
                                                            <path
                                                                d="M17 5v12c0 2.757-2.243 5-5 5s-5-2.243-5-5v-12c0-1.654 1.346-3 3-3s3 1.346 3 3v9c0 .551-.449 1-1 1s-1-.449-1-1v-8h-2v8c0 1.657 1.343 3 3 3s3-1.343 3-3v-9c0-2.761-2.239-5-5-5s-5 2.239-5 5v12c0 3.866 3.134 7 7 7s7-3.134 7-7v-12h-2z" />
                                                        </svg>
                                                        <span>
                                                        ' . $row["Report_URL"] . '
                                                        </span>
                                                    </div>
                                                    <a href="' . $row["Report_URL"] . '" class="text-purple-700 hover:underline">
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                                    // ... Display other fields ...
                                }
                            } else {
                                echo "No detailed information found for this order.";
                            }

                            $conn->close();
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>