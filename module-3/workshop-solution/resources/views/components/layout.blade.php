<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Frontend fejlesztés alapjai Laravellel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <x-nav></x-nav>
        
        <h1 class="mb-3 p-5 text-center bg-dark text-white">{{ $title ?? 'Home' }}</h1>

        @session('success')
            <div class="alert alert-success">{{ session('success') }}</div>
        @endsession

        @session('error')
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endsession

        {{ $slot }}
    </div>
</body>

</html>
