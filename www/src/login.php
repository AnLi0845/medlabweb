<?php
// Start the session
session_start();
// Check if the role is set in the request
if (isset($_POST['role'])) {
    $role = $_POST['role'];

    // Depending on the role, set up different login forms or processes
    if ($role == 'patient') {
        // Display patient login form
        echo '
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Patient Login</title>
            <link href="/dist/output.css" rel="stylesheet">
        </head>
        
        <body>
            <!-- component -->
            <div>
                <div class="relative min-h-screen  grid bg-black ">
        
                    <div
                        class="md:flex md:items-center md:justify-center w-full sm:w-auto md:h-full xl:w-1/2 p-8  md:p-10 lg:p-14 sm:rounded-lg md:rounded-none ">
                        <div class="max-w-xl w-full">
                            <div class="lg:text-left text-center">
        
                                <div class="flex items-center justify-center ">
                                    <div class="bg-black flex flex-col w-80 border border-gray-900 rounded-lg px-8 py-10">
                                        <div class="font-bold text-lg text-white "> '. $role .' Login </div>
                                        <form class="flex flex-col space-y-4 mt-10" action="LoginHandler.php" method="post">
                                            <label class="font-bold text-base text-white ">User name</label>
                                            <input type="text" name="username" placeholder="User name"
                                                class="border rounded-lg py-3 px-3 mt-4 bg-black border-indigo-600 placeholder-white-500 text-white">
                                            <label class="font-bold text-lg text-white">Password</label>
                                            <input type="password" name="password" placeholder="****"
                                                class="border rounded-lg py-3 px-3 bg-black border-indigo-600 placeholder-white-500 text-white">
                                            <input type="hidden" name="role" value="patient">
                                            <button type="submit" value="Login"
                                                class="border border-indigo-600 bg-black text-white rounded-lg py-3 font-semibold">Login</button>
                                        </form>
                                        <form action="index.php" method="post" class="flex flex-col space-y-4 mt-10">
                                            <button
                                                class="border border-indigo-600 bg-black text-white rounded-lg py-3 font-semibold">Back</button>
                                        </form>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
        </body>
        
        </html>
        ';
        // You can include patient-specific fields or information here
    } elseif ($role == 'staff') {
        // Display staff login form
        echo '
        <!DOCTYPE html>
        <html lang="en">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Staff Login</title>
            <link href="/dist/output.css" rel="stylesheet">
        </head>
        
        <body>
            <!-- component -->
            <div>
                <div class="relative min-h-screen  grid bg-black ">
        
                    <div
                        class="md:flex md:items-center md:justify-center w-full sm:w-auto md:h-full xl:w-1/2 p-8  md:p-10 lg:p-14 sm:rounded-lg md:rounded-none ">
                        <div class="max-w-xl w-full">
                            <div class="lg:text-left text-center">
        
                                <div class="flex items-center justify-center ">
                                    <div class="bg-black flex flex-col w-80 border border-gray-900 rounded-lg px-8 py-10">
                                        <div class="font-bold text-lg text-white "> '. $role .' Login </div>
                                        <form class="flex flex-col space-y-4 mt-10" action="LoginHandler.php" method="post">
                                            <label class="font-bold text-base text-white ">User name</label>
                                            <input type="text" name="username" placeholder="User number"
                                                class="border rounded-lg py-3 px-3 mt-4 bg-black border-indigo-600 placeholder-white-500 text-white">
                                            <label class="font-bold text-lg text-white">Password</label>
                                            <input type="password" name="password" placeholder="password"
                                                class="border rounded-lg py-3 px-3 bg-black border-indigo-600 placeholder-white-500 text-white">
                                            <input type="hidden" name="role" value="staff">
                                            <button type="submit" value="Login"
                                                class="border border-indigo-600 bg-black text-white rounded-lg py-3 font-semibold">Login</button>
                                        </form>
                                        <form action="index.php" method="post" class="flex flex-col space-y-4 mt-10">
                                            <button
                                                class="border border-indigo-600 bg-black text-white rounded-lg py-3 font-semibold">Back</button>
                                        </form>
                                    </div>
                                </div>
        
                            </div>
                        </div>
                    </div>
                </div>
        </body>
        
        </html>';
        // You can include staff-specific fields or information here
    } else {
        // Invalid role or unspecified, redirect back or show an error
        echo 'Invalid role selected.';
    }
} else {
    // No role provided, redirect back or show an error
    header('Location: index.php');
    exit;
    // Redirect to role selection page or handle the error as needed
} // ... The rest of your login logic goes here ...
?>