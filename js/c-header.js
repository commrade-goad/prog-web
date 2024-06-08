let header_div = document.getElementById("header");

header_div.innerHTML = `
<header class="p-3 text bg-dark">
    <div
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"
    >
        <a
            href="#"
            class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
        >
            <img src="/assets/logo.png" class="logo">
        </a>

        <ul
            class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0"
        > 
            <li class="px-2 text-white nav-link">Dashboard</li>
            <!-- <li><a href="#" class="nav-link px-2 text-white">Home</a></li> -->
            <!-- <li><a href="#" class="nav-link px-2 text-white">Features</a></li> -->
            <!-- <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li> -->
            <!-- <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li> -->
            <!-- <li><a href="#" class="nav-link px-2 text-white">About</a></li> -->
        </ul>

        <div class="text-end">
            <ul
                class="nav col-12 col-lg-auto me-lg-auto mb-2 mb-md-0"
            >
                <li><a href="#" class="nav-link px-2 text-white">Home</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Features</a></li>
                <li><a href="#" class="nav-link px-2 text-white">Pricing</a></li>
                <li><a href="#" class="nav-link px-2 text-white">FAQs</a></li>
                <li><a href="#" class="nav-link px-2 text-white">About</a></li>
            </ul>
            <!-- <button type="button" class="btn btn-outline-light me-2"> -->
            <!--     Logout -->
            <!-- </button> -->
        </div>
    </div>
</header>
`;
