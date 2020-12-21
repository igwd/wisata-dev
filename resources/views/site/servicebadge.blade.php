<section id="mu-service">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <div class="mu-service-area">
          <!-- Start single service -->
          @foreach($SERVICES as $service => $value)
          <!-- <div class="col-md-3 col-sm-3"> -->
            <div class="mu-service-single">
              <span class="{{$value['icon']}}"></span>
              <h3>{{$value['judul']}}</h3>
              <p>{!! $value['konten'] !!}</p>
              @if(!empty($value['site_url']))
                <a href="{{url('/')}}/{{$value['site_url']}}" class="btn btn-read-services" tabindex="0">Read More</a>
              @endif
            </div>
          <!-- </div> -->
          @endforeach
          <!-- Start single service -->
        </div>
      </div>
    </div>
  </div>
</section>