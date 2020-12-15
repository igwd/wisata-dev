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
          <li class="{{request()->routeIs('home') ? 'active' : ''}}"><a href="{{ route('home') }}">Home</a></li>            
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fasilitas <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{{url('/fasilitas/transportasi')}}">Transportasi</a></li>                
              <li><a href="{{url('/fasilitas/penginapan')}}">Penginapan</a></li>
              <li><a href="{{url('/fasilitas/kuliner')}}">Kuliner</a></li>                
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Galeri <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="{{url('/galeri/photo')}}">Photo</a></li>                
              <li><a href="{{url('/galeri/video')}}">Video</a></li>                
            </ul>
          </li>                      
          <li class="{{request()->routeIs('contact') ? 'active' : ''}}"><a href="{{ route('tiket') }}">Tiket</a></li>
          <!-- <li><a href="404.html">404 Page</a></li> -->               
          <li><a href="#" id="mu-search-icon"><i class="fa fa-search"></i></a></li>
        </ul>                     
      </div><!--/.nav-collapse -->        
    </div>     
  </nav>
</section>

<ul class="navbar-nav ml-auto">
    
</ul>