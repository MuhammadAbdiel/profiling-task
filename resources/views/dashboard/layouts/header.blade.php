<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/">Blog</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
        data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <input disabled class="form-control form-control-dark w-100" type="text" placeholder="" aria-label="Search"
        style="background-color: #212529;">
    <div class="navbar-nav">
        <div class="nav-item text-nowrap text-black">
            <a href="javascript:void(0)" class="nav-link px-3 bg-dark border-0 text-white btn-logout">
                Logout <span data-feather="log-out"></span></a>
        </div>
    </div>
</header>

<form action="/logout" id="logout-form" method="POST">
    @csrf
</form>