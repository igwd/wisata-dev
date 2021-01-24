@php
  use App\Models\Page;
  $config = array();
  $page = Page::all()->toArray();
  foreach ($page as $key => $value) {
    $config[$value['group']][] = $value;
  }
@endphp
<footer id="mu-footer">
  <!-- start footer top -->
  <div class="mu-footer-top">
    <div class="container">
      <div class="mu-footer-top-area">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="mu-footer-widget">
              <h4>Information</h4>
              <ul>
                <li><a href="#">About Us</a></li>
                <li><a href="{{route('termofuse')}}">Term Of Use</a></li>
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">{{ __('Administrator') }}</a></li>
                    @if (Route::has('register'))
                      <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @endif
                @else
                <li>
                  <a href="{{url('/admin')}}">{{Auth::user()->name}}</a>
                </li>
                @endguest
              </ul>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="mu-footer-widget">
              <h4>Contact</h4>
              <address>
                <p>{!!@$config['ALAMAT'][0]['konten']!!}</p>
                <p>Phone : {{@$config['P_CONTACT'][0]['konten']}}</p>
                <p>Email : {{@$config['EMAIL'][0]['konten']}}</p>
              </address>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end footer top -->
  <!-- start footer bottom -->
  <div class="mu-footer-bottom">
    <div class="container">
      <div class="mu-footer-bottom-area">
        <p>&copy; All Right Reserved.</a></p>
      </div>
    </div>
  </div>
  <!-- end footer bottom -->
</footer>