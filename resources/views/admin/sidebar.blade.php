@php
    $url = Request::route()->getName();
    //$url = explode('/',$url);
    //print_r($url);
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa fa-map"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Peng Empu <sup>waterfall</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @php echo(Request::segment(2) == 'dashboard' ? 'active' : '') @endphp">
        <a class="nav-link" href="{{url('/')}}/admin/dashboard"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Heading -->
    <div class="sidebar-heading">
        Data Pengunjung
    </div>
    <li class="nav-item @php echo(Request::segment(2) == 'grafik' ? 'active' : '') @endphp">
        <a class="nav-link" href="{{url('/admin/grafik')}}"><i class="fas fa-fw fa-chart-area"></i><span>Grafik Kunjungan</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Heading -->
    <div class="sidebar-heading">
        Manajemen Tiket
    </div>
    <li class="nav-item @php echo(Request::segment(2) == 'tiket' ? 'active' : '') @endphp">
        <a class="nav-link @php echo(Request::segment(2) == 'tiket' ? '' : 'collapsed') @endphp" href="#" data-toggle="collapse" data-target="#collapseTiket"
            aria-expanded="true" aria-controls="collapseTiket">
            <i class="fas fa-fw fa-tags"></i>
            <span>Tiket</span>
        </a>
        <div id="collapseTiket" class="collapse @php echo(Request::segment(2) == 'tiket' ? 'show' : '') @endphp" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Proses Administrasi</h6>
                <a class="collapse-item @php echo(Request::segment(3) == 'transaksi' ? 'active' : '') @endphp" href="{{url('/admin/tiket/transaksi')}}"><i class="far fa-calendar-check"></i> Pesan</a>
                <a class="collapse-item @php echo(Request::segment(3) == 'buktibayar' ? 'active' : '') @endphp" href="{{url('/admin/tiket/buktibayar')}}"><i class="far fa-money-bill-alt"></i> Bukti Pembayaran</a>
                <a class="collapse-item @php echo(Request::segment(3) == 'cetak' ? 'active' : '') @endphp" href="{{url('/admin/tiket/cetak')}}"><i class="fas fa-receipt"></i> Cetak Tiket</a>
                <a class="collapse-item @php echo(Request::segment(3) == 'setting' ? 'active' : '') @endphp" href="{{url('/admin/tiket/setting')}}"><i class="fa fa-cog"></i> Pengaturan Harga</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Manajemen Fasilitas
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @php echo(Request::segment(2) == 'fasilitas' ? 'active' : '') @endphp">
        <a class="nav-link @php echo(Request::segment(2) == 'fasilitas' ? '' : 'collapsed') @endphp" href="#" data-toggle="collapse"  data-target="#collapseFacilities" aria-expanded="@php echo(Request::segment(2) == 'fasilitas' ? 'true' : 'false') @endphp" aria-controls="collapseFacilities">
            <i class="fas fa-fw fa-folder"></i>
            <span>Fasilitas</span>
        </a>
        <div id="collapseFacilities" class="collapse @php echo(Request::segment(2) == 'fasilitas' ? 'show' : '') @endphp" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data</h6>
                <a class="collapse-item @php echo(Request::segment(3) == 'tempatmakan' ? 'active' : '') @endphp" href="{{url('/admin/fasilitas/tempatmakan')}}"><i class="fa fa-cutlery"></i> Tempat Makan</a>
                <a class="collapse-item @php echo(Request::segment(3) == 'penginapan' ? 'active' : '') @endphp" href="{{url('/admin/fasilitas/penginapan')}}"><i class="fas fa-home"></i> Penginapan</a>
                <a class="collapse-item @php echo(Request::segment(3) == 'transportasi' ? 'active' : '') @endphp" href="{{url('/admin/fasilitas/transportasi')}}"><i class="fa fa-car"></i> Transportasi</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Manajemen Galeri
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @php echo(Request::segment(2) == 'galeri' ? 'active' : '') @endphp">
        <a class="nav-link @php echo(Request::segment(2) == 'galeri' ? '' : 'collapsed') @endphp" href="#" data-toggle="collapse" data-target="#collapseGaleri"
            aria-expanded="true" aria-controls="collapseGaleri">
            <i class="fas fa-fw fa-folder"></i>
            <span>Galeri Photo & Video</span>
        </a>
        <div id="collapseGaleri" class="collapse @php echo(Request::segment(2) == 'galeri' ? 'show' : '') @endphp" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data</h6>
                <a class="collapse-item @php echo(Request::segment(3) == 'photo' ? 'active' : '') @endphp" href="{{url('/admin/galeri/photo')}}"><i class="fa fa-image"></i> Photo</a>
                <a class="collapse-item @php echo(Request::segment(3) == 'video' ? 'active' : '') @endphp" href="{{url('/admin/galeri/video')}}"><i class="fa fa-video"></i> Video</a>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <div class="sidebar-heading">
        Akses Kontrol
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-user"></i>
            <span>Users</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm fa-fw"></i>
            <span>{{ __('Logout') }}</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <!-- <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> -->
</ul>