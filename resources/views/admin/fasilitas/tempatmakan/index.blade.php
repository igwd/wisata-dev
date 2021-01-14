@extends('admin.template')
@section('content')
<div class="container-fluid">
	<div class="row">
    @if(Session::has('message'))
      @php 
        $messages = Session::get('message');
      @endphp
      <div class="alert {{@$messages['class']}}" style="display: block; width: 100%">
        @if(!empty($messages['text']))
          @foreach(@$messages['text'] as $err => $errvalue)
            {!!@$errvalue!!}<br>
          @endforeach
        @endif
      </div>
    @else
        <div class="alert" style="display: none; width: 100%"></div>
    @endif
  </div>
  <!-- Content Row -->
  <!-- Page Heading -->
  <div class="row">
      <h1 class="h3 text-gray-800">Manajemen Fasilitas</h1>
  </div>
  <div class="row">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin/fasilitas/tempatmakan">Tempat Makan</a></li>
      </ol>
    </nav>
    <div class="col-md-12 card">
    	<div class="card-header">
  			<h6 class="m-0 font-weight-bold text-primary"><button id="btn-add" class="btn btn-primary btn-sm float-right">Tambah Data</button></h6>
  		</div>
      <div class="card-body">
  			<div class="row">
  				<div class="table-responsive">
			    	<table id="data-fasilitas" class="table table-striped" style="width:100%">
	            <thead>
	                <th width="20%">Thumbnail</th>
	                <th width="70%">Nama Fasilitas</th>
	                <th width="10%">Aksi</th>
	            </thead>
	            <tbody></tbody>
	          </table>
	        </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
var tabel_fasilitas;
$(document).ready(function() {
  $('#btn-add').click(function(){
    window.location.href="{{url('admin/fasilitas/tempatmakan/create')}}"
  });

  tabel_fasilitas = $('#data-fasilitas').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '{{url("admin/fasilitas/tempatmakan/listData")}}',
      data: function(d) {
        /*d.id_universitas = $('#universitas').val();
        d.id_jenis_lomba = $('#kategori_lomba').val();
        d.verifikasi = $('#verifikasi').val();*/
      }
    },
    columns: [         
      {
        data: 'thumbnail',
        name: 'thumbnail',
        orderable: false,
        searchable: false,
        class: 'text-left'
      },
      {
        data: 'fasilitas',
        name: 'fasilitas',
        orderable: false,
        searchable: true,
        class: 'text-left'
      },
      {
        data: 'aksi',
        name: 'id',
        orderable: false,
        searchable: false,
        class: 'text-center'
      }
    ]
  });

  $('#data-fasilitas_filter input').unbind();
  $('#data-fasilitas_filter input').bind('keyup', function(e) {
    if(e.keyCode == 13) {
      tabel_fasilitas.search(this.value).draw();   
    }
  });
});

function deleteData(id){
  var id = $('#fasilitas'+id).data('id');
  var judul = $('#fasilitas'+id).data('fasilitas');
  console.log(judul);
  var file = $('#fasilitas'+id).data('file');
  var confirm = window.confirm("Hapus data Tempat Makan "+judul+" ?");
  if (confirm) {
    $.ajax({
      url : '{{url("admin/fasilitas/tempatmakan/")}}/'+id+"/destroy",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{'id':id,'nama_fasilitas':judul,'filename':file},
      type : 'DELETE',
      success:function(data){
        $('.alert').removeClass('alert-success alert-danger');
        $('.alert').css('display','none');
        $('.alert').addClass(data.class);
        $('.alert').html(data.text);
        $('.alert').css('display','block');
        tabel_fasilitas.ajax.reload();
      }
    });
  }
}
</script>
@endsection