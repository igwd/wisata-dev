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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Accomodation <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="course.html">Facilities</a></li>                
              <li><a href="course-detail.html">Transport</a></li>
              <li><a href="course-detail.html">Restaurant</a></li>                
            </ul>
          </li>           
          <li class="{{request()->routeIs('gallery') ? 'active' : ''}}"><a href="{{ route('gallery') }}">Gallery</a></li>            
          <li class="{{request()->routeIs('contact') ? 'active' : ''}}"><a href="contact.html">Contact</a></li>
          <!-- <li><a href="404.html">404 Page</a></li> -->

          <!-- Authentication Links -->
          @guest
              <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
              @if (Route::has('register'))
                <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
              @endif
          @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{Auth::user()->name}} <span class="fa fa-angle-down"></span></a>
            <ul class="dropdown-menu" role="menu">
              @if(session('role_active')==1)
              <li><a class="dropdown-item" href="admin">Dashboard</a></li>
              @else                              
              <li><a class="dropdown-item" href="#">Your Ticket</a></li>                              
              @endif
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
                </form>
              </li>
            </ul>
          </li>
          @endguest               
          <li><a href="#" id="mu-search-icon"><i class="fa fa-search"></i></a></li>
        </ul>                     
      </div><!--/.nav-collapse -->        
    </div>     
  </nav>
</section>

<ul class="navbar-nav ml-auto">
    
</ul>