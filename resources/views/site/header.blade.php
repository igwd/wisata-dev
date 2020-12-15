@php
  use App\Models\Page;
  $config = array();
  $page = Page::all()->toArray();
  foreach ($page as $key => $value) {
    $config[$value['group']][] = $value;
  }
@endphp
<header id="mu-header">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="mu-header-area">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="mu-header-top-left">
                <div class="mu-top-email" style="margin-right: 15px;">
                  <i class="{!!@$config['EMAIL'][0]['icon']!!}"></i>
                  <span>
                    {!!@$config['EMAIL'][0]['konten']!!} 
                  </span>
                </div>
                <div class="mu-top-email">
                  <i class="{{ @$config['P_CONTACT'][0]['icon'] }}"></i>
                  <span>{{ @$config['P_CONTACT'][0]['konten'] }}</span>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
              <div class="mu-header-top-right">
                <nav>
                  <ul class="mu-top-social-nav">
                    @if(!empty($config['SOSMED']))
                      @foreach($config['SOSMED'] as $row => $value)
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