@extends('site.template')
@section('navbar')
  @include('site/navbar')
@endsection
@section('content')
<section id="mu-page-breadcrumb">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-page-breadcrumb-area">
           <h2>Gallery</h2>
           <ol class="breadcrumb">
            <li><a href="{{url('/')}}">Home</a></li>            
            <li>Gallery</li>
            <li class="active">Photo</li>
          </ol>
         </div>
       </div>
     </div>
   </div>
 </section>
<!-- Start gallery  -->
 <section id="mu-gallery">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-gallery-area">
          <!-- start title -->
          <!-- <div class="mu-title">
            <h2>Some Moments</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maiores ut laboriosam corporis doloribus, officia, accusamus illo nam tempore totam alias!</p>
          </div> -->
          <!-- end title -->
          <!-- start gallery content -->
          <div class="mu-gallery-content">
            <!-- Start gallery menu -->
            <!-- <div class="mu-gallery-top">              
              <ul>
                <li class="filter active" data-filter="all">All</li>
                <li class="filter" data-filter=".lab">Lab</li>
                <li class="filter" data-filter=".classroom">Class Room</li>
                <li class="filter" data-filter=".library">Library</li>
                <li class="filter" data-filter=".cafe">Cafe</li>
                <li class="filter" data-filter=".others">Others</li>
              </ul>
            </div> -->
            <!-- End gallery menu -->
            <div class="mu-gallery-body">
              <ul id="mixit-container" class="row"> 
              @foreach($data as $photo=>$value)
                <li class="col-md-4 col-sm-6 col-xs-12 mix lab" style="display: inline-block;">
                  <div class="mu-single-gallery">                  
                    <div class="mu-single-gallery-item">
                      <div class="mu-single-gallery-img">
                        <a href="#"><img alt="{{$value->judul}}" src="{!!(!empty($value->thumbnail) ? url('/').'/'.$value->thumbnail : url('/').'/public/site/assets/img/gallery/small/1.jpg' )!!}"></a>
                      </div>
                      <div class="mu-single-gallery-info">
                        <div class="mu-single-gallery-info-inner">
                          <h4>{{$value->judul}}</h4>
                          <p>{!!$value->deskripsi!!}</p>
                          <a href="{!!(!empty($value->filename) ? url('/').'/'.$value->filename : url('/').'/public/site/assets/img/gallery/big/1.jpg' )!!}" data-fancybox-group="gallery" class="fancybox"><span class="fa fa-eye"></span></a>
                        </div>
                      </div>                  
                    </div>
                  </div>
                </li>
              @endforeach
              </ul>
            </div>
          </div>
          <!-- end gallery content -->
         </div>
       </div>
     </div>
     <div class="row">
        <div class="col-md-12" align="right">
          {{ $data->appends(Request::get('search'))->links()}} 
        </div>
     </div>
   </div>
 </section>
 <!-- End gallery  -->
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $("#search").on('keyup', function (e) {
      if (e.key === 'Enter' || e.keyCode === 13) {
        if($(this).val() !== ""){
            window.location.href = '{{url("galeri/photo?search=")}}'+$(this).val();
        }else{
          window.location.href = '{{url("galeri/photo")}}';
        }
      }
    });
  });
</script>
@endsection