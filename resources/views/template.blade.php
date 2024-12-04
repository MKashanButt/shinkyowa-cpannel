<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/root.css') }}">
    @isset($stylesheet)
        <link rel="stylesheet" href="{{ asset('css/' . $stylesheet) }}">
    @endisset
</head>

<body>
    <main>
        <x-sidebar />
        <div class="body">
            <x-topbar />
            @yield('content')
        </div>
    </main>
    {{-- JQUERY --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
