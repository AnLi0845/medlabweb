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
    <div class="h-screen w-full bg-white relative flex overflow-hidden">

        <!-- Sidebar -->
        <aside class="h-full w-16 flex flex-col space-y-10 items-center justify-center relative bg-gray-800 text-white">
            <!-- Profile -->
            <div
                class="h-10 w-10 flex items-center justify-center rounded-lg cursor-pointer hover:text-gray-800 hover:bg-white  hover:duration-300 hover:ease-linear focus:bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
            </div>
        </aside>



        <div class="w-full h-full flex flex-col justify-between">
            <!-- Header -->
            <header class="h-16 w-full flex items-center relative justify-end px-5 space-x-10 bg-gray-800">
                <!-- Informação -->
                <div class="flex flex-shrink-0 items-center space-x-4 text-white">

                    <!-- Texto -->
                    <div class="flex flex-col items-end ">
                        <!-- Name -->
                        <div class="text-md font-medium ">
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </div>
                        <!-- Role -->
                        <div class="text-sm font-regular">
                            <?php echo htmlspecialchars($_SESSION['role']); ?>
                        </div>
                    </div>
                    
                    <form action="logout.php" method="post">
                    
                    <button
                        class="!absolute right-1 top-1 z-10 rounded bg-pink-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg hover:shadow-pink-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none peer-placeholder-shown:pointer-events-none peer-placeholder-shown:bg-blue-gray-500 peer-placeholder-shown:opacity-50 peer-placeholder-shown:shadow-none"
                        type="submit" name="logout">
                        Logout
                    </button>
                    </form>
                    <!-- Log out -->

                </div>
            </header>

            <!-- Main -->
            <main class="max-w-full h-full flex relative overflow-y-hidden">
                <!-- Container -->
                <div
                    class="h-full w-full m-4 flex flex-wrap items-start justify-start rounded-tl grid-flow-col gap-4 overflow-y-scroll">
                    <!-- Container -->
                    <div class="w-96 h-60 rounded-lg flex-shrink-0 flex-grow bg-gray-400"></div>
                    <div class="w-96 h-60 rounded-lg flex-shrink-0 flex-grow bg-gray-400"></div>
                    <div class="w-96 h-60 rounded-lg flex-shrink-0 flex-grow bg-gray-400"></div>
                    <div class="w-96 h-60 rounded-lg flex-shrink-0 flex-grow bg-gray-400"></div>
                </div>
            </main>
        </div>

    </div>

</body>