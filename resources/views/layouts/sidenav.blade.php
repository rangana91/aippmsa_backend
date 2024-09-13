<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
    <div class="sidebar-inner px-2 pt-3">
        <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
            <div class="d-flex align-items-center">
                <div class="avatar-lg me-4">
                    <img src="/assets/img/team/profile-picture-3.jpg" class="card-img-top rounded-circle border-white"
                         alt="Bonnie Green">
                </div>
                <div class="d-block">
                    <h2 class="h5 mb-3">Hi, Jane</h2>
                    <a href="/login" class="btn btn-secondary btn-sm d-inline-flex align-items-center">
                        <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Sign Out
                    </a>
                </div>
            </div>
            <div class="collapse-close d-md-none">
                <a href="#sidebarMenu" data-bs-toggle="collapse" data-bs-target="#sidebarMenu"
                   aria-controls="sidebarMenu"
                   aria-expanded="true" aria-label="Toggle navigation">
                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
        <ul class="nav flex-column pt-3 pt-md-0">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link d-flex align-items-center">
                    <span class="mt-1 ms-1 sidebar-text">
            AIPPMSA
          </span>
                </a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                <a href="/dashboard" class="nav-link">
          <span class="sidebar-icon">
    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M3 3h4v4H3V3zm0 6h4v4H3v-4zm6-6h4v4h-4V3zm0 6h4v4h-4v-4zm6-6h4v4h-4V3zm0 6h4v4h-4v-4z"></path>
    </svg>
</span>
                    <span class="sidebar-text">Dashboard</span>

                </a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'categories' ? 'active' : '' }}">
                <a href="/categories" class="nav-link">
          <span class="sidebar-icon">
    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 2h12a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1zM3 4v12h14V4H3zM4 5h12v10H4V5z"></path>
    </svg>
</span>
                    <span class="sidebar-text">Categories</span>

                </a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'customers' ? 'active' : '' }}">
                <a href="/customers" class="nav-link">
          <span class="sidebar-icon">
    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-5 2a5 5 0 0110 0v1H5v-1z"></path>
    </svg>
</span>
                    <span class="sidebar-text">Customers</span>
                </a>
            </li>
            <li class="nav-item {{ Request::segment(1) == 'orders' ? 'active' : '' }}">
                <a href="/orders" class="nav-link">
          <span class="sidebar-icon">
    <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M5 2a1 1 0 00-1 1v1H2a1 1 0 00-1 1v1a1 1 0 001 1h2v1a1 1 0 001 1h1a1 1 0 001-1v-1h2a1 1 0 001-1V5a1 1 0 00-1-1h-2V3a1 1 0 00-1-1H5zM3 5h2v1H3V5zm4 0h2v1H7V5zm4 0h2v1h-2V5zM4 7h12v10H4V7zm0 12a2 2 0 01-2-2h2v2zm14 0v-2h2a2 2 0 01-2 2z"></path>
    </svg>
</span>
                    <span class="sidebar-text">Orders</span>
                </a>
            </li>

            <li class="nav-item">
        <span class="nav-link collapsed d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
              data-bs-target="#submenu-laravel" aria-expanded="true">
          <span>
            <span class="sidebar-icon"><i class="fab fa-laravel me-2" style="color: #fb503b;"></i></span>
            <span class="sidebar-text" style="color: #fb503b;">Item Types</span>
          </span>
          <span class="link-arrow"><svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"></path>
            </svg></span>
        </span>
                <div class="multi-level collapse show" role="list" id="submenu-laravel" aria-expanded="false">
                    <ul class="flex-column nav">
                        @foreach(\App\Constants\ItemTypes::getItems() as $item)
                            <li class="nav-item {{ Request::segment(2) === $item ? 'active' : '' }}">
                                <a href="/item/{{$item}}" class="nav-link">
                                    <span class="sidebar-text">{{\Illuminate\Support\Str::title($item)}}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>