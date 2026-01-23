@push('styles')
<style>
    /* Small Screens (mobile) */
    @media (max-width: 575.98px) {
        .navbar {
            padding: 0.5rem 0 !important;
        }
        .navbar-brand img {
            width: 80px !important;
        }
        .navbar-toggler {
            padding: 0.25rem 0.5rem;
        }
        .nav-link {
            padding: 0.5rem 0 !important;
            font-size: 14px;
        }
        .d-flex {
            flex-direction: column !important;
            width: 100%;
            margin-top: 10px;
        }
        .form-control {
            font-size: 13px;
            margin-bottom: 10px;
        }
        .form-control.me-2 {
            margin-right: 0 !important;
            margin-bottom: 8px;
        }
        .btn-outline-dark {
            width: 100%;
            padding: 0.5rem;
        }
        .userName {
            font-size: 12px;
            white-space: normal;
            margin-top: 10px;
            display: block;
        }
        #themeToggle {
            font-size: 18px;
            margin-top: 10px;
        }
    }

    /* Tablet Screens */
    @media (min-width: 576px) and (max-width: 991.98px) {
        .navbar {
            padding: 0.75rem 0 !important;
        }
        .navbar-brand img {
            width: 120px !important;
        }
        .form-control {
            font-size: 13px;
            max-width: 200px;
        }
        .userName {
            font-size: 13px;
            margin-left: 15px;
        }
        .nav-link {
            font-size: 14px;
        }
    }

    /* Large Screens */
    @media (min-width: 992px) {
        .navbar-brand img {
            width: 150px !important;
        }
    }
</style>
@endpush

<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm px-2">
    <div class="container px-0">
        <a class="navbar-brand" href="/">
            @if($settings && $settings->logo)
            <img
                src="{{ asset('storage/' . $settings->logo) }}"
                alt="abstore-logo" width='150'>
            @endif
        </a>
        <button class="navbar-toggler rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/orders">My Orders</a>
                </li>
            </ul>

            <form class="d-flex ms-auto my-2" role="search" action="/products" method="GET">
                <input class="form-control me-2 rounded-0" type="search" placeholder="Search" aria-label="Search"
                    name="search" value="{{ request('search') }}">
                <button class="btn btn-outline-dark rounded-0" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </button>
            </form>

            <a class="userName ms-auto" href="/profile">
                Welcome, {{ Auth::user()->name }}
            </a>

            <div id="themeToggle" class="ms-auto">
                🌙
            </div>
        </div>
    </div>
</nav>