{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asenso Pinoy Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .header {
            background-color: #ff8800;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        .header img {
            width: 200px;
        }

        .nav-bar {
            background-color: #ff8800;
            overflow: hidden;
        }

        .nav-bar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 16px;
        }

        .nav-bar a:hover {
            background-color: #ffbb33;
            color: white;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Header with Logo -->
    <div class="header">
        <img src="asensopinoy.png" alt="Asenso Pinoy Logo">
    </div>

    <!-- Navigation Bar -->
    <div class="nav-bar">
        <a href="#beneficiary">Beneficiary</a>
        <a href="#assistance">Assistance</a>
        <a href="#province">Province</a>
        <a href="#city">City/Municipality</a>
        <a href="#barangay">Barangay</a>
        <a href="#voucher">Voucher</a>
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <h1>Welcome to the Asenso Pinoy Admin Panel</h1>
        <p>Select an option from the navigation bar to manage data.</p>
    </div>

</body>
</html>

