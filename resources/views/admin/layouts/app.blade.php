<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>

    @include('admin.layouts.sidebar')

    <main>
        @include('admin.layouts.navbar')

        @yield('content')
    </main>

</body>
</html>
