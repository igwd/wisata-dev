@extends('admin.template')
@section('content')
<div class="container-fluid">
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
  <div class="row">
      <h1 class="h3 text-gray-800">Manajemen Tiket</h1>
  </div>
  <div class="row">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('/')}}/admin/tiket/cetak">Cetak Tiket</a></li>
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
  table_tiket = $('#data-fasilitas').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '{{url("admin/tiket/cetak/listDataCetakTiket")}}',
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

});
</script>
@endsection