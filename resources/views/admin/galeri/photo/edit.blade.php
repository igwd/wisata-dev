@extends('admin.template')
@section('content')
<style type="text/css">
  #map {
    height: 400px;
    /* The height is 400 pixels */
    width: 100%;
    /* The width is the width of the web page */
  }
</style>
<div class="container-fluid">
    <!-- Content Row -->
  <!-- Page Heading -->
  <div class="row">
      <h1 class="h3 text-gray-800">Manajemen Galeri</h1>
  </div>
    <div class="row">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{url('/')}}/admin">Galeri</a></li>
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin/galeri/photo">Photo</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit - {{@$data->judul}}</li>
      </ol>
    </nav>
      <div class="col-md-12 card">
        <div class="card-body">
          @if(Session::has('message'))
            @php 
              $messages = Session::get('message');
            @endphp
            <p class="alert {{@$messages['class']}}">
              @foreach(@$messages['text'] as $err => $errvalue)
                {!!@$errvalue!!}<br>
              @endforeach
            </p>
          @endif
          <form id="form-data" name="form-data" method="POST" enctype="multipart/form-data" action="{{url('/')}}/admin/galeri/photo/{{$data->id}}/update">
            <!-- form reqiure laravel -->
            <input type="hidden" name="_method" value="PUT">
            @csrf
            <!-- form require laravel end -->
            <div class="form-group">
              <input type="hidden" name="group_kategori" value="PHOTO">
              <label>Judul</label>
              <input type="text" class="form-control" name="judul" id="judul" value="{{@$data->judul}}">
            </div>
            <div class="form-group">
              <label>Deskripsi</label>
              <textarea id="deskripsi" name="deskripsi" class="summernote form-control">{{@$data->deskripsi}}</textarea>
            </div>
            <div class="form-group">
              <label>Upload Gambar</label>
              <input type="hidden" name="url_gambar" id="url_gambar" value="{{$data->filename}}">
              <input type="file" name="image" class="form-control" id="image">
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
      window.location.href = "{{url('/admin/galeri/photo')}}"; 
    });

    $('.summernote').summernote();
    initMap();
  });
</script>
@endsection
