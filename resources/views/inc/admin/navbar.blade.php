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
            <ul class="navbar-nav">
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