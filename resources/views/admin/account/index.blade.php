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
      <h1 class="h3 text-gray-800">Manajemen User</h1>
  </div>
  <div class="row">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
      </ol>
    </nav>
    <div class="col-md-12 card">
    	<div class="card-header">
  			<h6 class="m-0 font-weight-bold text-primary"><button id="btn-add" class="btn btn-primary btn-sm float-right">Tambah Data</button></h6>
  		</div>
      <div class="card-body">
  			<div class="row">
  				<div class="table-responsive">
			    	<table id="data-user" class="table table-striped" style="width:100%">
	            <thead>
	                <th width="40%">Nama</th>
	                <th width="40%">Username</th>
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
var tabel_user;
$(document).ready(function() {

	tabel_user = $('#data-user').DataTable({
	    processing: true,
	    serverSide: true,
	    ajax: {
	      url: '{{url("admin/account/listData")}}',
	      data: function(d) {
	        /*d.id_universitas = $('#universitas').val();
	        d.id_jenis_lomba = $('#kategori_lomba').val();
	        d.verifikasi = $('#verifikasi').val();*/
	      }
	    },
	    columns: [         
	      {
	        data: 'name',
	        name: 'name',
	        orderable: false,
	        searchable: false,
	        class: 'text-left'
	      },
	      {
	        data: 'email',
	        name: 'email',
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

	$('#data-user_filter input').unbind();
	$('#data-user_filter input').bind('keyup', function(e) {
	    if(e.keyCode == 13) {
	      tabel_user.search(this.value).draw();   
	    }
	});
  	
  	$('#btn-add').click(function(){
		var url = "{{url('/')}}/admin/account/create";
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
});

function edit(id){
	var url = "{{url('/')}}/admin/account/create";
	if(id != ""){
		url = "{{url('/')}}/admin/account/"+id+"/edit";
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

function resetPassword(id){
	var url = "{{url('/')}}/admin/account/"+id+'/resetpassword';
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

function deleteData(id){
	var kode = $('#btn-delete'+id).attr('data-name');
  	var confirm = window.confirm("Hapus data User #"+kode+" ?");
	if (confirm) {
	    $.ajax({
	      url : '{{url("admin/account")}}/'+id+"/destroy",
	      headers: {
	        'X-CSRF-TOKEN': '{{ csrf_token() }}'
	      },
	      data:{'id':id,'name':kode},
	      type : 'DELETE',
	      success:function(data){
	        $('.alert').removeClass('alert-success alert-danger');
	        $('.alert').css('display','none');
	        $('.alert').addClass(data.class);
	        $('.alert').html(data.text);
	        $('.alert').css('display','block');
	        tabel_user.ajax.reload();
	      }
	    });
   	}
}
</script>
@endsection