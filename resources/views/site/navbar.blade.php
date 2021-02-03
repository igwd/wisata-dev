<style type="text/css">
  .dropdown-menu > .active > a, .dropdown-menu > .active > a:hover, .dropdown-menu > .active > a:focus {
    color: #fff !important;
    text-decoration: none;
    background-color: #3fc35f;
    outline: 0;
  }
</style>
<section id="mu-menu">
  <nav class="navbar navbar-default" role="navigation">  
    <div class="container">
      <div class="navbar-header">
        <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!-- LOGO -->              
        <!-- TEXT BASED LOGO -->
        <a class="navbar-brand" href="#"><i class="fa fa-map-o"></i><span>PENG EMPU <small style="font-size:10px ">waterfall</small></span></a>
        <!-- IMG BASED LOGO  -->
        <!-- <a class="navbar-brand" href="index.html"><img src="assets/img/logo.png" alt="logo"></a> -->
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
          <li class="{{request()->routeIs('home') ? 'active' : ''}}"><a href="{{ route('home') }}">Beranda</a></li>            
          <li class="dropdown @php echo(Request::segment(1) == 'fasilitas' ? 'active' : '') @endphp">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fasilitas <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li class="@php echo(Request::segment(2) == 'transportasi' ? 'active' : '') @endphp"><a href="{{url('/fasilitas/transportasi')}}">Transportasi</a></li>                
              <li class="@php echo(Request::segment(2) == 'penginapan' ? 'active' : '') @endphp"><a href="{{url('/fasilitas/penginapan')}}">Penginapan</a></li>
              <li class="@php echo(Request::segment(2) == 'kuliner' ? 'active' : '') @endphp"><a href="{{url('/fasilitas/kuliner')}}">Kuliner</a></li>                
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Galeri <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{{url('/galeri/photo')}}">Foto</a></li>                
              <li><a href="{{url('/galeri/video')}}">Video</a></li>                
            </ul>
          </li>                      
          <li class="@php echo(Request::segment(1) == 'tiket' ? 'active' : '') @endphp">
            <a href="{{ route('tiket') }}">Tiket</a>
          </li>
          <!-- <li><a href="404.html">404 Page</a></li> -->               
          <li class="@php echo(Request::segment(1) == 'booking' ? 'active' : '') @endphp">
            <a href="{{url('/booking/cart')}}"> Pesanan <span class="badge badge-danger badge-counter" id="cart-number">0</span></a>
          </li>
          <li><a href="{{ route('tiket.check') }}">Cek Status Tiket</a></li>
          <li><a href="#" id="mu-search-icon"><i class="fa fa-search"></i></a></li>
        </ul>                     
      </div><!--/.nav-collapse -->        
    </div>     
  </nav>
</section>

<ul class="navbar-nav ml-auto">
    
</ul>