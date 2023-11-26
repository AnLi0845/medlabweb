<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedLab</title>
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
                                <form class="flex flex-col space-y-4" action="login.php" method="post">
                                    <button type="submit" name="role" value="patient"
                                        class="border border-indigo-600 bg-black text-white rounded-lg py-3 font-semibold">Patient Lgoin</button>
                                    <button type="submit" name="role" value="staff"
                                        class="border border-indigo-600 bg-black text-white rounded-lg py-3 font-semibold">Staff Lgoin</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</body>

</html>