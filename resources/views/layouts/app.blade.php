<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    {{-- <link rel="icon" type="image/x-icon" href="/images/favicon.ico"> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/dashboardPhotographer.css'])
</head>
<body>
 <div id="app">
    
        @include('layouts.navigation')

        
       <main>@yield('content')</main> 
 </div>
</body>
</html>