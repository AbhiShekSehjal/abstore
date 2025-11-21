<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- favicon -->
    <link rel="shortcut icon"
        href="https://res.cloudinary.com/djmmx0tri/image/upload/v1763698644/vecteezy_shopping-cart-set-of-shopping-cart-icon-on-white_9157893_q2vrvd.jpg"
        type="image/x-icon" />


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

    <style>
    * {
        font-family: "Montserrat", sans-serif;
        font-weight: 500;
    }

    h1 {
        font-family: "Jost", sans-serif;
    }

    .adminProfilePic {
        width: 60px !important;
        height: 60px !important;
        /* border-radius: 50% !important; */
        object-fit: cover;
        border: 0.5px solid grey;
    }
    </style>

    @stack('styles')

</head>

<body>

    @include ('inc/admin/navbar')

    <div class='container border-top p-0 overflow-hidden'>
        @yield('content')
    </div>

    @include ('inc/admin/footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    @stack('scripts')

</body>

</html>