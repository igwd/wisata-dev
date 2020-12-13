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
	        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Slide Show</a></li>
	        <li class="breadcrumb-item active" aria-current="page">Create</li>
	      </ol>
	    </nav>
      <div class="col-md-12 card">
        <div class="card-body">
        	@if(Session::has('message'))
						@php 
							$messages = Session::get('message');
						@endphp
						<p class="alert {{$messages['class']}}">{{ $messages['text'] }}</p>
					@endif
          <form id="form-data" name="form-data" method="POST" enctype="multipart/form-data" action="{{url('/')}}/admin/slideshow/store">
            <!-- form reqiure laravel -->
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <!-- form require laravel end -->
            <div class="form-group">
              <label>Tema</label>
              <input type="text" class="form-control" name="tema" id="tema" value="{{@$form->tema}}" required>
            </div>
            <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control" name="judul" id="judul" value="{{@$form->judul}}" required>
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea id="deskripsi" name="deskripsi" class="summernote form-control" required>{{@$form->deskripsi}}</textarea>
            </div>
            <div class="form-group">
              <label>Upload Gambar</label>
              <input type="hidden" name="url_gambar" id="url_gambar" value="{{@$form->url_gambar}}">
              <input type="file" name="image" class="form-control" id="image" required>
            </div>
          </form>
          <div class="group-btn pull-right">
            <button id="btn-simpan" class="btn btn-success">Simpan</button>
            <button id="btn-batal" class="btn btn-danger">Batal</button>
          </div>
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

    $('#btn-batal').click(function(){
      window.location.href = "{{url('/admin')}}"; 
    });
    
    $('.summernote').summernote();
  });
</script>
@endsection
