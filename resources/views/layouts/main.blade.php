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