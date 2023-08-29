<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.header')
    @yield('styles')
    <title>@yield('title')</title>
</head>
<body>
    <div class="w-full h-full min-h-screen">
        @yield('content')
    </div>



    @yield('scripts')
</body>
</html>
