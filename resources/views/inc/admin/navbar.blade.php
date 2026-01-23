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
            font-size: 13px;
            padding: 0.5rem 0 !important;
        }
        .userName {
            font-size: 11px;
            white-space: normal;
            margin-top: 10px;
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
        .nav-link {
            font-size: 13px;
        }
        .userName {
            font-size: 12px;
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

<nav class="navbar navbar-expand-lg bg-body-white">
    <div class="container px-0">
        <a class="navbar-brand" href="/admin/index"><img
                src="https://res.cloudinary.com/djmmx0tri/image/upload/v1763620634/Group_1_rlhqbh.png"
                alt="abstore-logo" width='150'></a>
        <button class="navbar-toggler rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/admin/index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/categories">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/settings">Settings</a>
                </li>
            </ul>

            <a class="userName ms-auto" href="/admin/profile">
                Welcome, {{ Auth::user()->name }}
            </a>

            <div id="themeToggle" class="ms-auto">
                🌙
            </div>
        </div>
    </div>
</nav>