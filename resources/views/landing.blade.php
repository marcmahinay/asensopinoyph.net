<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body, html {
                height: 100%;
                margin: 0;
            }
            .fullscreen-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                padding: 15px;
                box-sizing: border-box;
            }
            .responsive-image {
                width: 100%;
                max-width: 300px;
            }
            @media (min-width: 768px) {
                .responsive-image {
                    max-width: 400px;
                }
            }
            @media (min-width: 1024px) {
                .responsive-image {
                    max-width: 500px;
                }
            }
        </style>
    </head>
    <body>
        <div class="fullscreen-container">
            <img src="{{ asset('assets/img/asensopinoy.png') }}" alt="ASENSO PINOY LOGO" class="responsive-image">
        </div>
    </body>
</html>