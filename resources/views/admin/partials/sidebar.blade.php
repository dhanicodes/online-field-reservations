<link href="/css/admin/sidebar.css" rel="stylesheet">

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">Karsa Mini Soccer</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('admin') ? 'active' : '' }}">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ Request::is('admin/lapangan') ? 'active' : '' }}">
        <a class="nav-link " href="{{ Route('index-lapangan') }}">
            <i class="fas fa-futbol"></i>
            <span>Lapangan</span></a>
    </li>
    <li class="nav-item {{ Request::is('admin/permintaan-pembatalan') ? 'active' : '' }}">
        <a class="nav-link " href="{{ Route('index-cancel') }}">
            <i class="fas fa-fw fa-ban"></i>
            <span>Permintaan Pembatalan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
