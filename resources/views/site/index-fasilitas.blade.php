@extends('site.template')
@section('navbar')
  @include('site/navbar')
@endsection
@section('content')
<style type="text/css">
  #mu-course-content {
    background-color: #f8f8f8;
    display: inline;
    float: left;
    padding: 30px 0 !important;
    width: 100%;
}
</style>
<section id="mu-page-breadcrumb">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-page-breadcrumb-area">
           <h2>Lihat Disekitar</h2>
           <ol class="breadcrumb">
            <li><a href="#">Fasilitas</a></li>            
            <li class="active">
            @php
              echo ucwords($segment);
            @endphp
            </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="mu-course-content">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-course-content-area">
            <div class="row">
              <div class="col-md-9">
                <!-- start gallery content -->
                <div class="mu-gallery-area">
                  <div class="mu-gallery-content">
                    <div class="mu-gallery-body">
                      <ul id="mixit-container" class="row"> 
                      @foreach($data as $photo=>$value)
                        <li class="col-md-4 col-sm-6 col-xs-12 mix lab" style="display: inline-block;">
                          <div class="mu-single-gallery">                  
                            <div class="mu-single-gallery-item">
                              <div class="mu-single-gallery-img">
                                <a href="{{url('/')}}/fasilitas/{{$segment}}/{{$value->id}}/detail"><img width="80%" alt="{{$value->judul}}" src="{!!(!empty($value->thumbnail) ? url('/').'/'.$value->thumbnail : url('/').'/public/site/assets/img/gallery/small/1.jpg' )!!}"></a>
                              </div>
                              <div class="mu-single-gallery-info">
                                <div class="mu-single-gallery-info-inner">
                                  <h4>{{$value->nama_fasilitas}}</h4>
                                  <p>{!!$value->alamat_fasilitas!!}</p>
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
                <!-- end gallery content -->
                <!-- start blog navigation -->
                <div class="row">
                  <div class="col-md-12" align="right">
                  {{ $data->appends(Request::get('search'))->links()}} 
                  </div>
                </div>
                <!-- end blog navigation -->
              </div>
              <div class="col-md-3">
                <!-- start sidebar -->
                <aside class="mu-sidebar">
                  <!-- start single sidebar -->
                  <div class="mu-single-sidebar">
                    <h3>Most Popular</h3>
                    <div id="popular" class="mu-sidebar-popular-courses">
                      <!-- derived from ajax-->
                    </div>
                  </div>
                </aside>
                <!-- / end sidebar -->
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      url:"{{url('/')}}/fasilitas/{{$segment}}/popular",
      type:"GET",
      dataType:"JSON",
      success:function(data){
        $('#popular').html(data);
      },error:function(error){
        console.log(error.XMLHttpRequest);
        $('#popular').html("Not Found");
      }
    });

    $("#search").on('keyup', function (e) {
      if (e.key === 'Enter' || e.keyCode === 13) {
        if($(this).val() !== ""){
            window.location.href = '{{url("fasilitas/")}}/{{$segment}}?search='+$(this).val();
        }else{
          window.location.href = '{{url("fasilitas/")}}/{{$segment}}';
        }
      }
    });

  });
</script>
@endsection