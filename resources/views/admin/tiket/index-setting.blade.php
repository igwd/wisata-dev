@extends('admin.template')
@section('content')
<div class="container-fluid">
	<div class="row">
		@if(Session::has('message'))
	    @php 
	      $messages = Session::get('message');
	    @endphp
	    <div style="width:100%;display: none" class="alert {{@$messages['class']}}">
	      @if(!empty($messages['text']))
	        @foreach(@$messages['text'] as $err => $errvalue)
	          {!!@$errvalue!!}<br>
	        @endforeach
	      @endif
	    </div>
		@else
		    <div style="width:100%;display: none" class="alert"></div>
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
		    <li class="breadcrumb-item"><a href="{{url('/')}}/admin/tiket/buktibayar">Setting Tiket</a></li>
		  </ol>
		</nav>
		<div class="col-md-12 card">
			<div class="card-header">
					<h6 class="m-0 font-weight-bold text-primary"><button id="btn-add" class="btn btn-primary btn-sm float-right">Tambah Data</button></h6>
				</div>
		  	<div class="card-body">
					<div class="row">
						<div class="table-responsive">
				    <table id="data-tiket" class="table table-striped" style="width:100%">
			            <thead>
			                <th width="20%">Nama Tiket</th>
			                <th width="30%">Keterangan</th>
			                <th width="10%">Harga</th>
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
<div id="div-modal"></div>
@endsection
@section('script')
<script type="text/javascript">
var table_tiket;
$(document).ready(function() {
	$('#btn-add').click(function(){
		var url = "{{url('/')}}/admin/tiket/setting/create";
		$.ajax({
			url:url,
			headers: {
	        	'X-CSRF-TOKEN': '{{ csrf_token() }}'
		    },
		    type : 'GET',
		    success:function(data){
		        $('#div-modal').html(data);
		    }
		});
	});

	table_tiket = $('#data-tiket').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
		url: '{{url("admin/tiket/setting/listDataMasterTiket")}}',
		data: function(d) {
			/*d.id_universitas = $('#universitas').val();
			d.id_jenis_lomba = $('#kategori_lomba').val();
			d.verifikasi = $('#verifikasi').val();*/
			}
		},
		columns: [         
			{
				data: 'mt_nama_tiket',
				name: 'mt_nama_tiket',
				orderable: false,
				searchable: true,
				class: 'text-left'
				},
				{
				data: 'mt_keterangan',
				name: 'mt_keterangan',
				orderable: false,
				searchable: true,
				class: 'text-left'
				},
				{
				data: 'mt_harga',
				name: 'mt_harga',
				orderable: true,
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

	$('#data-tiket_filter input').unbind();
	$('#data-tiket_filter input').bind('keyup', function(e) {
		if(e.keyCode == 13) {
			table_tiket.search(this.value).draw();   
		}
	});

	$('#data-tiket .btn-delete').click(function(){
		alert('tai');
		console.log($(this).data('mt_nama_tiket'));
	});
});


function showFormData(id){
	var url = "{{url('/')}}/admin/tiket/setting/create";
	if(id != ""){
		url = "{{url('/')}}/admin/tiket/setting/"+id+"/edit";
	}
	$.ajax({
		url:url,
		headers: {
        	'X-CSRF-TOKEN': '{{ csrf_token() }}'
	    },
	    data : {'mt_id':id},
	    type : 'GET',
	    success:function(data){
	        $('#div-modal').html(data);
	    }
	});
}

function deleteTiket(id){
  //var id = $('#btn-delete'+id).data('id');
  var kode = $('#btn-delete'+id).attr('data-nama');

  var confirm = window.confirm("Hapus data Tiket #"+kode+" ?");
  if (confirm) {
    $.ajax({
      url : '{{url("admin/tiket/setting")}}/'+id+"/destroy",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data:{'id':id,'mt_nama_tiket':kode},
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