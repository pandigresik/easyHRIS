<header class="header header-sticky mb-4">
    <div class="container-fluid">
        <button class="header-toggler px-md-0 me-md-3" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            <svg class="icon icon-lg">
                <use xlink:href="vendor/coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
        </button>
        <!--
        <a class="header-brand d-md-none" href="#">
            <div class="sidebar-brand-full" width="118" height="46" alt="CoreUI Logo">
                <img src="vendor/images/logo.png">
        </a>
        -->
        <ul class="header-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link py-0" data-coreui-toggle="dropdown" href="#" role="button"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">                        
                        <img class="avatar-img" src="vendor/images/default-avatar.jpg"
                            alt="user@email.com">
                    </div>                    
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-light py-2">
                        <div class="fw-semibold">Settings</div>
                    </div><a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendor/coreui/icons/svg/free.svg#cil-user"></use>
                        </svg> Profile</a>
                    <a class="dropdown-item" href="{{ route('password.change') }}">
                        <i class="cil-lock-locked"></i>
                        Change Password</a>
                    <a class="dropdown-item" href="#">
                        <svg class="icon me-2">
                            <use xlink:href="vendor/coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg> Settings</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item" href="#">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="c-icon cil-account-logout"></i>&nbsp;
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf </form>
                </div>
            </li>
        </ul>
    </div>
    <div class="header-divider"></div>
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            @stack('breadcrumb')
        </nav>
    </div>
</header>