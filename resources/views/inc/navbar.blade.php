<nav class="navbar navbar-expand-lg bg-body-white">
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
                <!-- <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/cart">Cart</a>
                </li>
            </ul>
            <!-- <a class="nav-link ms-auto" href="/profile">
                <img src="https://res.cloudinary.com/djmmx0tri/image/upload/v1753439425/samples/man-portrait.jpg" class='userProfilePic' alt="userProfilePic">
            </a> -->
            <a class="nav-link ms-auto" href="/profile">
               Welcome, {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>