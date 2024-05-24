<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{ route('profil.index') }}" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/person.jpg') }}" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                    <span class="text-secondary text-small">Administrator</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'dashboard') active @endif">
            <a class="nav-link" href="{{ route('dashboard.index') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'users') active @endif">
            <a class="nav-link" href="{{ route('users.index') }}">
                <span class="menu-title">Users</span>
                <i class="mdi mdi-account menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'master-banner') active @endif">
            <a class="nav-link" href="{{ route('master-banner.index') }}">
                <span class="menu-title">Master Banner</span>
                <i class="mdi mdi-bullhorn menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'master-kupon') active @endif">
            <a class="nav-link" href="{{ route('master-kupon.index') }}">
                <span class="menu-title">Master Kupon</span>
                <i class="mdi mdi-ticket menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'kategori') active @endif">
            <a class="nav-link" href="{{ route('kategori.index') }}">
                <span class="menu-title">Kategori Produk</span>
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'produk') active @endif">
            <a class="nav-link" href="{{ route('produk.index') }}">
                <span class="menu-title">Produk</span>
                <i class="mdi mdi-flower menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'konfirm-pembayaran') active @endif">
            <a class="nav-link" href="#">
                <span class="menu-title">Konfirmasi Pembayaran</span>
                <i class="mdi mdi-pen menu-icon"></i>
            </a>
        </li>
        <li class="nav-item @if(Request::segment(1) == 'produk-terjual') active @endif">
            <a class="nav-link" href="#">
                <span class="menu-title">Produk Terjual</span>
                <i class="mdi mdi-margin menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>