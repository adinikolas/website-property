<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Title Dinamis (Diambil dari @section('title') di masing-masing halaman) -->
    <title>@yield('title', 'Beranda') - CKM City Karawang</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon_ckm_city.png') }}">

    <!-- FontAwesome CDN untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* CSS Reset Dasar */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        /* Efek scroll halus */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body>

    @yield('content')

</body>
</html>
