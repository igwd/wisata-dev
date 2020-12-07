@extends('admin.template')
@section('content')
<div class="container-fluid">
    <!-- Content Row -->
	<!-- Page Heading -->
	<div class="row">
	    <h1 class="h3 text-gray-800">Manajemen Halaman Web</h1>
	</div>
    <div class="row">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page">Edit - {{$data->judul}}</li>
			</ol>
		</nav>
    	<div class="col-md-12 card">
    		<div class="card-body">
		    	<form id="form-data" name="form-data" method="POST" action="{{url('/')}}/admin/updatehalaman/{{$data->id}}">
		    		<!-- form reqiure laravel -->
		    		<input type="hidden" name="_method" value="PUT">
		    		@csrf
		    		<!-- form require laravel end -->
		    		<div class="form-group">
		    			<label>Judul</label>
		    			<input type="hidden" name="group" value="{{$data->group}}">
		    			<input type="text" class="form-control" name="judul" id="judul" value="{{$data->judul}}">
		    		</div>
		    		<div class="form-group">
		    			<label>Konten</label>
		    			<textarea id="konten" name="konten" class="summernote form-control">{{$data->konten}}</textarea>
		    		</div>
		    		<div class="form-group">
		    			<label>Icon</label>
		    			<input type="text" name="icon" class="form-control" id="icon" value="{{$data->icon}}">
		    		</div>
		    		<div class="form-group">
		    			<label>Link Eksternal</label>
		    			<input type="text" name="site_url" class="form-control" id="site_url" value="{{$data->site_url}}">
		    		</div>
		    	</form>
	    		<button id="btn-simpan">Simpan</button>
		    </div>
	    </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#btn-simpan').click(function(){
			$('#form-data').submit();
		});

		$('.summernote').summernote();
	});
</script>
@endsection
