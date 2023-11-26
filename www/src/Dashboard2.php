<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    <a href="logout.php"
                        class="hover:bg-white/10 transition duration-150 ease-linear rounded-lg py-3 px-2 group">
                        <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 space-x-2 items-center">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-6 h-6 group-hover:text-indigo-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>

                            </div>
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
                    <h1 class="font-bold py-4 uppercase">Order List</h1>
                    <div class="overflow-x-scroll">
                        <table class="w-full whitespace-nowrap">
                            <thead class="bg-black/60">
                                <th class="text-left py-3 px-2 rounded-l-lg">Test Name</th>
                                <th class="text-left py-3 px-2">Physician</th>
                                <th class="text-left py-3 px-2">Billed Amount</th>
                                <th class="text-left py-3 px-2">Order Status</th>
                                <th class="text-left py-3 px-2 rounded-r-lg">More Info</th>
                            </thead>
                            <?php 
                                include 'db-connect.php';
                                // Assuming the logged-in user's ID is stored in session
                                $patientId=$_SESSION['patient_id']; // SQL query to fetch order details 
                                $sql = "SELECT o.Order_ID, tc.Test_Name, s.First_Name as Physician_First_Name, s.Last_Name as Physician_Last_Name, b.Billed_Amount, o.Status FROM Orders o JOIN Tests_Catalog tc ON o.Test_Code = tc.Test_Code JOIN Staff s ON o.Ordering_Physician = s.Staff_ID JOIN Billing b ON o.Order_ID = b.Order_ID WHERE o.Patient_ID = ?;";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $patientId);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Check if there are orders
                                if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                echo '
                                <tr class="border-b border-gray-700">
                                    <td class="py-3 px-2 font-bold">'
                                    .$row["Test_Name"].'
                                    </td>
                                    <td class="py-3 px-2">'.$row["Physician_First_Name"].' '.$row["Physician_Last_Name"].'</td>
                                    <td class="py-3 px-2">$'.$row["Billed_Amount"].'</td>
                                    <td class="py-3 px-2">'.$row["Status"].'</td>
                                    <td class="py-3 px-2">
                                        <div class="inline-flex items-center space-x-3">
                                            <a href="" title="Edit" class="hover:text-white">
                                                Detail
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                ';
                                }
                                } else {
                                echo "No orders found";
                                }
                                $conn->close();
                                ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>