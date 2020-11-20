<!DOCTYPE html>
<html lang="en">
  <head>
    @include('/site/metadata')
  </head>
  <body> 
  <!--START SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#">
      <i class="fa fa-angle-up"></i>      
    </a>
  <!-- END SCROLL TOP BUTTON -->

  <!-- Start header  -->
  @include('site/header')
  <!-- End header  -->
  <!-- Start menu -->
	@yield('navbar')
  <!-- End menu -->
  <!-- Start search box -->
  <div id="mu-search">
    <div class="mu-search-area">      
      <button class="mu-search-close"><span class="fa fa-close"></span></button>
      <div class="container">
        <div class="row">
          <div class="col-md-12">            
            <form class="mu-search-form">
              <input type="search" placeholder="Type Your Keyword(s) & Hit Enter">              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End search box -->
  @yield('content')

  <!-- Start footer -->
  @include('site/footer')
  <!-- End footer -->
  
  @include('site/script')
	@yield('script')
  </body>
</html>