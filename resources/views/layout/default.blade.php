<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        @vite('resources/css/app.css')
    </head>
    <body class="h-full">

        <div class="min-h-full">
            <x-layout.navbar />

            @yield('content')

        </div>

        @yield('script')
    </body>
</html>
