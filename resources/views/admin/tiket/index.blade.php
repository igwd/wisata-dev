@extends('admin.template')
@section('content')
<div class="container-fluid">
	<div class="row">
		@if(Session::has('message'))
	    @php 
	      $messages = Session::get('message');
	    @endphp
	    <div style="width: 100%" class="alert {{@$messages['class']}}">
	      @if(!empty($messages['text']))
	        @foreach(@$messages['text'] as $err => $errvalue)
	          {!!@$errvalue!!}<br>
	        @endforeach
	      @endif
	    </div>
		@else
		    <div style="width: 100%" class="alert" style="display: none"></div>
		@endif
	</div>
  <!-- Content Row -->
  <!-- Page Heading -->
  <div class="row">
      <h1 class="h3 text-gray-800">Manajemen Tiket</h1>
  </div>
  <div class="row">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin/tiket/buktibayar">Bukti Bayar</a></li>
      </ol>
    </nav>
    <div class="col-md-12 card">
      <div class="card-body">
  			<div class="row">
  				<div class="table-responsive">
			    <table id="data-fasilitas" class="table table-striped" style="width:100%">
		            <thead>
		                <th width="20%">Bukti Bayar</th>
		                <th width="50%">Tiket Booking</th>
		                <th width="30%">Aksi</th>
		            </thead>
		            <tbody></tbody>
	          	</table>
	        	</div>
        	</div>
      </div>
    </div>
  </div>
</div>
<div id="div-modal-upload"></div>
@endsection
@section('script')
<script type="text/javascript">
var table_tiket;
$(document).ready(function() {
  $('#btn-add').click(function(){
    window.location.href="{{url('admin/fasilitas/penginapan/create')}}"
  });

  table_tiket = $('#data-fasilitas').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '{{url("admin/tiket/buktibayar/listData")}}',
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
        data: 'tiket',
        name: 'tiket',
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
      table_tiket.search(this.value).draw();   
    }
  });

  $('.btn-approve').click(function(){
  	
	
  });
});

function approveBuktiBayar(id){
	var id = $('#btn-approve'+id).data('id');
	var kode = $('#btn-approve'+id).data('kode');
	$.ajax({
		url:"{{url('/')}}/admin/tiket/buktibayar/"+id+"/approveBuktiBayar",
		headers: {
        	'X-CSRF-TOKEN': '{{ csrf_token() }}'
	    },
	    data : {'it_kode_unik':kode},
	    type : 'PUT',
	    success:function(data){
	        $('.alert').removeClass('alert-success alert-danger');
	        $('.alert').css('display','none');
	        $('.alert').addClass(data.class);
	        $('.alert').html(data.text);
	        $('.alert').css('display','block');
	        table_tiket.ajax.reload();
	    }
	});
}

function formUploadBuktiBayar(id){
	$.ajax({
		url:"{{url('/')}}/admin/tiket/buktibayar/formUploadBuktiBayar",
		headers: {
        	'X-CSRF-TOKEN': '{{ csrf_token() }}'
	    },
	    data : {'it_kode_unik':id},
	    type : 'GET',
	    success:function(data){
	        $('#div-modal-upload').html(data);
          $('#modal-upload').modal('show');
	    }
	});
}

function deleteTiket(id){
  //var id = $('#btn-delete'+id).data('id');
  var kode = $('#btn-delete'+id).attr('data-kode');

  var confirm = window.confirm("Hapus data Tiket #"+id+" ?");
  if (confirm) {
    $.ajax({
      url : '{{url("admin/tiket/buktibayar")}}/'+id+"/destroy",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{'id':id,'it_kode_unik':kode},
      type : 'DELETE',
      success:function(data){
        $('.alert').removeClass('alert-success alert-danger');
        $('.alert').css('display','none');
        $('.alert').addClass(data.class);
        $('.alert').html(data.text);
        $('.alert').css('display','block');
        table_tiket.ajax.reload();
      }
    });
  }
}
</script>
@endsection