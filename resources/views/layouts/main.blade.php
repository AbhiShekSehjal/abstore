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

    <!-- Slider  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">


    <style>
        h1 {
            font-family: "Jost", sans-serif;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #b2adadff;
        }

        ::-webkit-scrollbar-thumb {
            background: #000000ff;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .userProfilePic {
            width: 60px !important;
            height: 60px !important;
            border-radius: 50% !important;
            object-fit: cover;
            border: 0.5px solid grey;
        }

        .userName {
            color: black;
            text-decoration: none;
        }

        #themeToggle {
            cursor: pointer;
        }

        :root {
            --bg-color: #ffffff;
            --text-color: #111827;
            --card-bg: #f3f4f6;
        }

        .dark-mode {
            --bg-color: #1E1E1E;
            --text-color: #E5E7EB;
            --card-bg: white;
        }

        /* Use variables everywhere */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .card {
            background-color: var(--card-bg);
        }

        .socialMediaLink {
            mix-blend-mode: difference;
            color: white;
            opacity: 0.7;
        }

        /* Responsive adjustments for main content */
        @media (max-width: 575.98px) {
            body {
                font-size: 14px;
            }
            h1 {
                font-size: 28px !important;
            }
            h2 {
                font-size: 22px;
            }
            h3 {
                font-size: 18px;
            }
            .container {
                padding: 0 10px;
            }
        }

        @media (min-width: 576px) and (max-width: 991.98px) {
            body {
                font-size: 15px;
            }
            h1 {
                font-size: 32px !important;
            }
            h2 {
                font-size: 24px;
            }
            h3 {
                font-size: 19px;
            }
        }



        :root {
            --bg-color: #ffffff;
            --text-color: #111827;
            --card-bg: #f3f4f6;
        }

        .dark-mode {
            --bg-color: #1E1E1E;
            --text-color: #E5E7EB;
            --card-bg: white;
        }

        /* Use variables everywhere */
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .card {
            background-color: var(--card-bg);
        }

        .socialMediaLink {
            mix-blend-mode: difference;
            color: white;
            opacity: 0.7;
        }

        /* ===============================
           NAVBAR RESPONSIVE STYLES
        =============================== */

        /* Default styles for larger screens */
        .navbar {
            padding: 12px 0 !important;
        }

        .navLogo img {
            width: 150px;
            height: auto;
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link {
            font-size: 1rem;
            font-weight: 500;
            padding: 8px 12px !important;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #6c757d !important;
        }

        form[role="search"] {
            width: auto;
            margin: 0 !important;
        }

        form[role="search"] input {
            font-size: 0.95rem;
            padding: 8px 12px !important;
            border-radius: 0 !important;
            min-width: 200px;
        }

        form[role="search"] button {
            border-radius: 0 !important;
            padding: 8px 12px !important;
        }

        .userName {
            font-size: 0.95rem;
            font-weight: 500;
            white-space: nowrap;
            padding: 8px 12px !important;
        }

        #themeToggle {
            font-size: 1.3rem;
            cursor: pointer;
            padding: 8px 12px !important;
            transition: transform 0.3s ease;
        }

        #themeToggle:hover {
            transform: scale(1.1);
        }

        /* ===============================
           TABLET & BELOW (991px and down)
        =============================== */
        @media (max-width: 991.98px) {
            .navbar {
                padding: 10px 0 !important;
            }

            .navLogo img {
                width: 130px;
            }

            .navbar-collapse {
                padding-top: 15px;
                border-top: 1px solid #e9ecef;
                margin-top: 10px;
            }

            .navbar-nav {
                text-align: center;
                width: 100%;
            }

            .navbar-nav .nav-item {
                margin: 8px 0;
            }

            .navbar-nav .nav-link {
                font-size: 1rem;
                padding: 10px 0 !important;
            }

            /* Search bar adjustments */
            form[role="search"] {
                width: 100% !important;
                margin: 12px 0 !important;
                display: flex;
            }

            form[role="search"] input {
                width: 100% !important;
                font-size: 0.95rem;
                flex: 1;
            }

            form[role="search"] button {
                margin-left: 0 !important;
            }

            /* Username & theme toggle - stacked */
            .userName {
                display: block !important;
                text-align: center;
                margin: 12px 0 !important;
                font-size: 0.95rem;
                padding: 8px 0 !important;
                width: 100%;
            }

            #themeToggle {
                display: block !important;
                text-align: center;
                margin: 8px 0 !important;
                font-size: 1.2rem;
                padding: 8px 0 !important;
                width: 100%;
            }
        }

        /* ===============================
           MOBILE ONLY (575px and down)
        =============================== */
        @media (max-width: 575.98px) {
            .navbar {
                padding: 8px 8px !important;
            }

            .container {
                padding-left: 8px !important;
                padding-right: 8px !important;
            }

            /* Logo smaller on mobile */
            .navLogo img {
                width: 110px;
            }

            .navbar-toggler {
                border: none !important;
                box-shadow: none !important;
                padding: 4px 8px !important;
            }

            .navbar-collapse {
                padding-top: 12px;
                margin-top: 8px;
            }

            .navbar-nav .nav-item {
                margin: 6px 0;
            }

            .navbar-nav .nav-link {
                font-size: 0.9rem;
                padding: 8px 0 !important;
            }

            /* Search bar - stack on mobile */
            form[role="search"] {
                width: 100% !important;
                margin: 10px 0 !important;
                flex-direction: column;
            }

            form[role="search"] input {
                width: 100% !important;
                font-size: 0.85rem;
                padding: 8px 8px !important;
                margin-bottom: 6px;
            }

            form[role="search"] button {
                width: 100% !important;
                font-size: 0.9rem;
            }

            /* Username on mobile */
            .userName {
                font-size: 0.85rem;
                margin: 10px 0 !important;
                padding: 6px 0 !important;
            }

            #themeToggle {
                font-size: 1.1rem;
                margin: 8px 0 !important;
                padding: 6px 0 !important;
            }
        }

        /* ===============================
           EXTRA SMALL (360px and down)
        =============================== */
        @media (max-width: 360px) {
            .navLogo img {
                width: 90px;
            }

            .navbar-nav .nav-link {
                font-size: 0.8rem;
            }

            form[role="search"] input {
                font-size: 0.8rem;
            }

            .userName {
                font-size: 0.8rem;
            }
        }

        /* footer css */
        
    </style>

    @stack('styles')

</head>

<body>

    @include ('inc/navbar')

    <div class='border-top p-0 overflow-hidden'>
        @yield('content')
    </div>

    @include ('inc/footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("themeToggle");
            const body = document.body;

            // Load saved theme
            const savedTheme = localStorage.getItem("theme");
            if (savedTheme === "dark") {
                body.classList.add("dark-mode");
                toggleBtn.innerText = "☀️";
            }

            toggleBtn.addEventListener("click", function() {
                body.classList.toggle("dark-mode");

                if (body.classList.contains("dark-mode")) {
                    localStorage.setItem("theme", "dark");
                    toggleBtn.innerText = "☀️";
                } else {
                    localStorage.setItem("theme", "light");
                    toggleBtn.innerText = "🌙";
                }
            });
        });
    </script>

    @stack('scripts')

</body>

</html>