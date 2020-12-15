@extends('admin.template')
@section('content')
<style type="text/css">
	#mu-gallery {
	    display: inline;
	    float: left;
		padding: 0px !important; 
		width: 100%;
	}
	#mu-gallery .mu-gallery-area .mu-gallery-content .mu-gallery-top {
	    display: inline;
	    float: left;
	    margin-top: 10px !important;
	    padding: 0px !important; 
	    width: 100%;
	}

	#mu-gallery .mu-gallery-area .mu-gallery-content .mu-gallery-body ul li .mu-single-gallery .mu-single-gallery-item {
	    display: inline;
	    float: left;
	    width: 100%; 
	    position: relative;
	    border-color: #4e73df !important;
	    border: double !important;
	}

	#mu-gallery .mu-gallery-area .mu-gallery-content .mu-gallery-body {
	    display: inline;
	    float: left;
	    width: 100%;
	    margin-top: 20px !important;
	}
</style>
<section id="mu-gallery">
   <div class="container">
   	@if(Session::has('message'))
    @php 
      $messages = Session::get('message');
    @endphp
    <p class="alert {{@$messages['class']}}">
      @if(!empty($messages['text']))
        @foreach(@$messages['text'] as $err => $errvalue)
          {!!@$errvalue!!}<br>
        @endforeach
      @endif
    </p>
	@else
	  <p class="alert" style="display: none"></p>
	@endif
	<!-- Content Row -->
	<!-- Page Heading -->
	<h1 class="h3 text-gray-800">
		Manajemen Galeri
	</h1>
	<div class="row">
		<div class="col-md-12">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active"><a href="{{url('/')}}/admin">Home</a></li>
					<li class="breadcrumb-item active"><a href="{{url('/')}}/admin">Galeri</a></li>
					<li class="breadcrumb-item"><a href="{{url('/')}}/admin/galeri/photo">Photo</a></li>
				</ol>
			</nav>
		</div>
	</div>
<div class="row">
	<div class="col-md-12">
		<div class="mu-gallery-area">
			<!-- start gallery content -->
			<div class="mu-gallery-content">
				<!-- Start gallery menu -->
				<div class="row mu-gallery-content">
					<div class="col-md-12">
						<div class="mu-gallery-top">
							<button id="btn-add" class="btn btn-primary pull-left btn-sm">Tambah Data</button>              
							<div class="pull-right">
								<input type="input" name="search" id="search" class="form-control input-sm" placeholder="Search" value="{{Request::get('search')}}">
							</div>
						</div>
					</div>
					<div class="col-md-12">
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
													<!-- <a href="{!!(!empty($value->filename) ? url('/').'/'.$value->filename : url('/').'/public/site/assets/img/gallery/big/1.jpg' )!!}"><span class="fa fa-eye"></span></a> -->
													<a href="{!!url('/admin/galeri/photo').'/'.$value->id.'/edit'!!}"><span class="fa fa-edit"></span></a>
													<a href="#" class="aa-link"><span class="fa fa-trash"></span></a>
												</div>
											</div>                  
										</div>
									</div>
								</li>
							@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
   </div>
   <div class="row">
	   <div class="col-md-12">
	        {{ $data->appends(Request::get('search'))->links()}} 
	   </div>
   </div>
 </section>
@endsection
@section('script')
<script type="text/javascript">
var tabel_fasilitas;
$(document).ready(function() {
	$('#btn-add').click(function(){
		window.location.href="{{url('admin/galeri/photo/create')}}"
	});

	$("#search").on('keyup', function (e) {
	    if (e.key === 'Enter' || e.keyCode === 13) {
	    	if($(this).val() !== ""){
		        window.location.href = '{{url("admin/galeri/photo?search=")}}'+$(this).val();
		    }else{
		    	window.location.href = '{{url("admin/galeri/photo")}}';
		    }
	    }
	});
});

function deleteData(){
  console.log('judul',judul);
  var id = $('.btn-delete').data('id');
  var judul = $('.btn-delete').data('judul');
  var file = $('.btn-delete').data('file');
  var confirm = window.confirm("Hapus data Slide Show "+judul+" ?");
  if (confirm) {
    $.ajax({
      url : '{{url("admin/slideshow")}}/'+id+"/destroy",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{'id':id,'judul':judul,'file':file},
      type : 'DELETE',
      success:function(data){
        $('.alert').removeClass('alert-success alert-danger');
        $('.alert').css('display','none');
        $('.alert').addClass(data.class);
        $('.alert').html(data.text);
        $('.alert').css('display','block');
        table_slide_show.ajax.reload();
      }
    });
  }
}
</script>
@endsection