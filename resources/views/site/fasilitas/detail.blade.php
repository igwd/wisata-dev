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

.checked {
  color: orange;
}

.rate:hover{
  color: orange;
}

.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}

.mu-latest-course-single-content ul {
    margin-bottom: 30px;
}

.mu-latest-course-single-content ul li {
    margin-bottom: 10px;
}

.mu-latest-course-single-content h4 {
  border-bottom: 1px solid #ccc !important;
  padding-bottom: 10px !important;
}

.mu-latest-course-single-content ul li span:first-child {
    display: inline-block !important;
    min-width: 150px !important;
    float: left !important;
}
</style>
<section id="mu-page-breadcrumb">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-page-breadcrumb-area">
           <h2>{{$data->nama_fasilitas}}</h2>
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
                <div class="mu-latest-course-single">
                  <figure class="mu-latest-course-img">
                    <a href="#"><img src="{{url('/')}}/{{$data->thumbnail}}" alt="img"></a>
                    <figcaption class="mu-latest-course-imgcaption">
                      <div class='rating-stars pull-left' style="font-size: 12px">
                        <ul id='stars'>
                          <li class='star' title='Poor' data-value='1'>
                            <i class='fa fa-star fa-fw'></i>
                          </li>
                          <li class='star' title='Fair' data-value='2'>
                            <i class='fa fa-star fa-fw'></i>
                          </li>
                          <li class='star' title='Good' data-value='3'>
                            <i class='fa fa-star fa-fw'></i>
                          </li>
                          <li class='star' title='Excellent' data-value='4'>
                            <i class='fa fa-star fa-fw'></i>
                          </li>
                          <li class='star' title='WOW!!!' data-value='5'>
                            <i class='fa fa-star fa-fw'></i>
                          </li>
                        </ul>
                      </div>
                      <span><i class="fa fa-star"></i>@php echo(empty($data->skor) ? 'Belum memiliki review' : $data->skor)@endphp</span>
                    </figcaption>
                  </figure>
                  <div class="mu-latest-course-single-content">
                    <button class="btn btn-success" id="btn-booking">Book Now !</button>
                  </div>
                  <div class="mu-latest-course-single-content">
                    <h4>Informasi Pemesanan</h4>
                    <ul>
                      <li> <span>Harga Booking</span> <span>Rp. {!!number_format($data->mt_harga)!!} ,-</span></li>
                      <li> <span>Lokasi</span> <span>{{$data->alamat_fasilitas}}</span></li>
                    </ul>
                    <h4>Deskripsi</h4>
                    {!!$data->deskripsi!!}
                  </div>
                </div>
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
     <input type="hidden" id="keyid" name="keyid" value="{!!Crypt::encryptString($data->id)!!}">
     <input type="hidden" id="nama_fasilitas" name="nama_fasilitas" value="{{$data->nama_fasilitas}}">
     <input type="hidden" id="harga_booking" name="harga_booking" value="{{$data->mt_harga}}">
   </div>
</section>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    getCartItem();
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


    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function(){
      var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
     
      // Now highlight all the stars that's not after the current hovered star
      $(this).parent().children('li.star').each(function(e){
        if (e < onStar) {
          $(this).addClass('hover');
        }
        else {
          $(this).removeClass('hover');
        }
      });
      
    }).on('mouseout', function(){
      $(this).parent().children('li.star').each(function(e){
        $(this).removeClass('hover');
      });
    });
    
    
    /* 2. Action to perform on click */
    $('#stars li').on('click', function(){
      var onStar = parseInt($(this).data('value'), 10); // The star currently selected
      var stars = $(this).parent().children('li.star');
      
      for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('selected');
      }
      
      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
      }
      
      // JUST RESPONSE (Not needed)
      var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      var msg = "";
      if (ratingValue > 1) {
          msg = "Thanks! You rated this " + ratingValue + " stars.";
      }
      else {
          msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
      }
      responseMessage(msg);
    });

    $('#btn-booking').click(function(){
      bookingFasilitas();
    });
  });
</script>
@endsection