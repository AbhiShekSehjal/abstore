<nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm">
    <div class="container px-0">
        <a class="navbar-brand" href="/"><img
                src="https://res.cloudinary.com/djmmx0tri/image/upload/v1763620634/Group_1_rlhqbh.png"
                alt="abstore-logo" width='150'></a>
        <button class="navbar-toggler rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
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

            <a class="nav-link ms-auto" href="/profile">
                Welcome, {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>