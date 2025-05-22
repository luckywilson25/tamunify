<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) - {{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/fontawesome/css/all.min.css') }}">
    @stack('styles')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins text-gray-900 antialiased">

    <header class="absolute top-0 left-0 right-0 z-10 bg-white/90 border-b">
        <div class="w-full mx-auto flex justify-between items-center">
            @include('components.header')
        </div>
    </header>
    <div class="pt-24">
        {{ $slot }}
    </div>


    <script src="{{ asset('assets/vendors/fontawesome/js/all.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @if (isset($script))
    {{ $script }}
    @endif
</body>

</html>
