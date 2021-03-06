<!DOCTYPE html>
<html class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/app.css?v=12') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="https://fonts.googleapis.com/css?family=Dancing+Script|Bad+Script|Didact+Gothic&amp;subset=cyrillic" rel="stylesheet"> --}}

    {{-- Inertia --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script>

    {{-- Ping CRM --}}
    <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script>
   
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @routes
</head>
<body data-app class="font-sans leading-none text-gray-700 antialiased">

@inertia

</body>
</html>
