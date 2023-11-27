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
    <title>Profile</title>
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
                    <h4 class="text-xl font-bold py-4 ">Profile</h4>
                    <div class="overflow-x-scroll">
                        
                        <!-- Info -->
                        <div class="my-4 flex flex-col 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4">
                            <div class="w-full flex flex-col 2xl:w-1/3">
                                <div class="flex-1 bg-white rounded-lg shadow-xl p-8">
                                    <h4 class=" text-slate-300 font-bold"></h4>
                                    <ul class="mt-2 text-gray-700">
                                        <li class="flex border-y py-2">
                                            <span class="font-bold w-24">Full name:</span>
                                            <span class="text-gray-700">Amanda S. Ross</span>
                                        </li>
                                        <li class="flex border-b py-2">
                                            <span class="font-bold w-24">Birthday:</span>
                                            <span class="text-gray-700">24 Jul, 1991</span>
                                        </li>
                                        <li class="flex border-b py-2">
                                            <span class="font-bold w-24">Joined:</span>
                                            <span class="text-gray-700">10 Jan 2022 (25 days ago)</span>
                                        </li>
                                        <li class="flex border-b py-2">
                                            <span class="font-bold w-24">Mobile:</span>
                                            <span class="text-gray-700">(123) 123-1234</span>
                                        </li>
                                        <li class="flex border-b py-2">
                                            <span class="font-bold w-24">Email:</span>
                                            <span class="text-gray-700">amandaross@example.com</span>
                                        </li>
                                        <li class="flex border-b py-2">
                                            <span class="font-bold w-24">Location:</span>
                                            <span class="text-gray-700">New York, US</span>
                                        </li>
                                        <li class="flex border-b py-2">
                                            <span class="font-bold w-24">Languages:</span>
                                            <span class="text-gray-700">English, Spanish</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>