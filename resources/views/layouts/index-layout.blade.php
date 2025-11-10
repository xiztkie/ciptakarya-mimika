@props(['title' => '', 'subtitle' => '', 'active' => ''])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' ? $title . ' - ' : '' }}{{ config('app.name') }}</title>
    @if (isset($meta))
        {{ $meta }}
    @endif

    <link rel="icon" href="{{ asset('assets/images/logo.png') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white">
    <main>
        {{ $slot }}
    </main>
</body>

</html>
@include('sweetalert::alert')
