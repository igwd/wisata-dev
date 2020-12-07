<section id="mu-slider">  
  <!-- Start single slider item -->
  @php
    use App\Models\SlideShow;
  @endphp
  @foreach(SlideShow::all() as $slide => $value)
  <div class="mu-slider-single">
    <div class="mu-slider-img">
      <figure>
        <img src="{{(!empty($value->url_gambar) ? url('/').$value->url_gambar : url('/').'/public/site/assets/img/slider/1.jpg')}}" alt="{{$value->judul}}">
      </figure>
    </div>
    <div class="mu-slider-content">
      <h4>{{$value->tema}}</h4>
      <span></span>
      <h2>{{$value->judul}}</h2>
      <p>{{$value->deskripsi}}</p>
    </div>
  </div>
  @endforeach
</section>