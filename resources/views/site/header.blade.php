<header id="mu-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="mu-header-area">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="mu-header-top-left">
                <div class="mu-top-email">
                  <i class="@php (empty($EMAIL) ? '' : $EMAIL[0]['icon']) @endphp"></i>
                  <span>
                    @php (empty($EMAIL) ? '' : $EMAIL[0]['konten']) @endphp 
                  </span>
                </div>
                <div class="mu-top-email">
                  <i class="{{ @$P_CONTACT[0]['icon'] }}"></i>
                  <span>{{ @$P_CONTACT[0]['konten'] }}</span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="mu-header-top-right">
                <nav>
                  <ul class="mu-top-social-nav">
                    @if(!empty($SOSMED))
                      @foreach($SOSMED as $row => $value)
                      <li><a href="{{@$value['site_url']}}" target="_blank"><span class="{{@$value['icon']}}"></span></a></li>
                      @endforeach
                    @endif
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>