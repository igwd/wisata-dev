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
	@php
		$data_booking = @$data['booking'];
		$data_tiket_order = (array) @$data['tiket'];
		$data_kuliner_order = (array) @$data['kuliner'];
		$data_penginapan_order = (array) @$data['penginapan'];
		$data_transport_order = (array) @$data['transport'];
		$total_tiket = 0; $total_kuliner = 0; $total_penginapan = 0; $total_transport = 0;
	@endphp
	<div class="row">
	  <h1 class="h3 text-gray-800">Manajemen Tiket</h1>
	</div>
	<div class="row">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="{{url('/')}}/admin">Home</a></li>
		    <li class="breadcrumb-item"><a href="{{url('/')}}/admin/tiket/buktibayar">Transaksi Tiket</a></li>
		  </ol>
		</nav>
		<div class="col-md-12 card">
		  	<div class="card-body">
				<form role="form" id="form-data" name="form-data" method="POST" action="{{url('/')}}/booking/proses">
					<!-- form reqiure laravel -->
					<input type="hidden" name="_method" value="POST">
					@csrf
					<!-- form require laravel end -->
						<h4>Data Tiket</h4>
						<div class="row">
							<div class="col-md-8">
							@php
							    use App\Models\Tiket;
							@endphp 
							<p>
								Informasi harga tiket : 
								<ul style="font-size: 14px;">
								@foreach(Tiket::all() as $tiket => $value)
									<li>{{$value->mt_nama_tiket}} <small>({{$value->mt_keterangan}})</small> : <i>Rp. {!!number_format($value->mt_harga)!!}</i></li>
								@endforeach
								</ul>	 
							</p>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label style="text-align: right !important;">Tanggal Booking</label>
									<input type="text" readonly style="text-align: right; padding-right: 15px;" class="datepicker form-control" id="tanggal" name="tanggal" value="{!!(!empty($booking->tanggal) ? @$data_booking->tanggal : date('Y-m-d')) !!}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th width="20%"> Tiket </th>
											<th width="10%"> Harga </th>
											<th width="10%"> Jumlah </th>
											<th width="30%" style="text-align:right"> Total </th>
										</tr>
									</thead>
									<tbody>
										@foreach(Tiket::all() as $tiket => $value)
										<tr>
											<td>
												{{$value->mt_nama_tiket}}
												<input type="hidden" name="booking_group[{{$value->mt_id}}]" id="booking_group{{$value->mt_id}}" class="form-control" value="TIKET">
												<input type="hidden" name="booking_name[{{$value->mt_id}}]" id="booking_name{{$value->mt_id}}" class="form-control" value="{{$value->mt_nama_tiket}}">
											</td>
											<td align="right"> 
												{!!number_format($value->mt_harga)!!} 
												<input type="hidden" name="harga[{{$value->mt_id}}]" id="harga{{$value->mt_id}}" class="form-control" value="{{$value->mt_harga}}">
											</td>
											<td>
												<input type="number" style="text-align:right;" name="qty[{{$value->mt_id}}]" id="qty{{$value->mt_id}}" data-tiketid="{{$value->mt_id}}" data-harga="{{$value->mt_harga}}" class="qty form-control" value="{!!(!empty($data_tiket_order[$value->mt_id]->booking_qty) ? $data_tiket_order[$value->mt_id]->booking_qty : 0)!!}">
											</td>
											<td align="right">
												<input type="text" style="text-align:right;" readonly name="subtotal[{{$value->mt_id}}]" id="subtotal{{$value->mt_id}}" class="subtotal form-control" value="{!!(!empty($data_tiket_order[$value->mt_id]->booking_subtotal) ? number_format($data_tiket_order[$value->mt_id]->booking_subtotal) : 0)!!}">
											</td>
										</tr>
										@php 
											$total_tiket += @$data_tiket_order[$value->mt_id]->booking_subtotal; 
										@endphp
										@endforeach
									</tbody>
									<tfoot>
										<td colspan="3">Total</td>
										<td align="right">
											<input readonly type="text" style="text-align: right;" value="{!!number_format($total_tiket)!!}" name="total" class="form-control" id="total">
										</td>
									</tfoot>
								</table>
							</div>
						</div>
						<h4>Kuliner</h4>
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th width="20%"> Voucher </th>
											<th width="10%"> Harga </th>
											<th width="10%"> Jumlah </th>
											<th width="30%" style="text-align:right"> Total </th>
											<th width="5%">Aksi</th>
										</tr>
									</thead>
									<tbody>
									@if(empty($data_kuliner_order))
										<tr>
											<td>
												<input type="hidden" name="booking_group[]" id="booking_group1" class="form-control" value="KULINER">
												<input type="text" readonly onclick="modalFasilitas('TEMPAT_MAKAN')" name="booking_name[]" id="booking_name1" class="form-control" value="{{$value->booking_name}}">
											</td>
											<td align="right"> 
												<input type="number" readonly name="harga[]" id="harga1" class="form-control" value="{{$value->booking_price}}">
											</td>
											<td>
												<input type="number" readonly style="text-align:right;" name="qty[]" id="qty1" data-tiketid="" data-harga="" class="qty form-control" value="">
											</td>
											<td align="right">
												<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal1" class="subtotal form-control" value="">
											</td>
											<td>
												<input class="btn btn-danger btn-sm" type="button" value="Delete" onclick="deleteRow(this)"/>
											</td>
										</tr>
									@else
										@foreach(@$data_kuliner_order as $kuliner => $value)
										<tr>
											<td>
												{{$value->booking_name}}
												<input type="hidden" name="booking_group[{{$kuliner}}]" id="booking_group{{$kuliner}}" class="form-control" value="KULINER">
												<input type="hidden" name="booking_name[{{$kuliner}}]" id="booking_name{{$kuliner}}" class="form-control" value="{{$value->booking_name}}">
											</td>
											<td align="right"> 
												{!!number_format($value->booking_price)!!} 
												<input type="hidden" name="harga[{{$kuliner}}]" id="harga{{$kuliner}}" class="form-control" value="{{$value->booking_price}}">
											</td>
											<td>
												<input type="number" readonly style="text-align:right;" name="qty[{{$kuliner}}]" id="qty{{$kuliner}}" data-tiketid="{{$kuliner}}" data-harga="{{$value->booking_price}}" class="qty form-control" value="{!!(!empty($data_kuliner_order[$kuliner]->booking_qty) ? $data_kuliner_order[$kuliner]->booking_qty : 0)!!}">
											</td>
											<td align="right">
												<input type="text" style="text-align:right;" readonly name="subtotal[{{$kuliner}}]" id="subtotal{{$kuliner}}" class="subtotal form-control" value="{!!(!empty($data_kuliner_order[$kuliner]->booking_subtotal) ? number_format($data_kuliner_order[$kuliner]->booking_subtotal) : 0)!!}">
											</td>
											<td>
												<input class="btn btn-danger btn-sm" type="button" value="Delete" onclick="deleteRow(this)"/>
											</td>
										</tr>
										@php 
										$total_kuliner += @$data_kuliner_order[$kuliner]->booking_subtotal; 
										@endphp
										@endforeach
									@endif
									</tbody>
									<tfoot>
										<td colspan="3">Total</td>
										<td align="right">
											<input readonly type="text" style="text-align: right;" value="{!!number_format($total_kuliner)!!}" name="total" class="form-control" id="total">
										</td>
									</tfoot>
								</table>
							</div>
						</div>
						<h4>Penginapan</h4>
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th width="20%"> Voucher </th>
											<th width="10%"> Harga </th>
											<th width="10%"> Jumlah </th>
											<th width="30%" style="text-align:right"> Total </th>
											<th width="5%">Aksi</th>
										</tr>
									</thead>
									<tbody>
									@if(empty($data_penginapan_order))

									@else
										@foreach(@$data_penginapan_order as $penginapan => $value)
										<tr>
											<td>
												{{$value->booking_name}}
												<input type="hidden" name="booking_group[{{$penginapan}}]" id="booking_group{{$penginapan}}" class="form-control" value="PENGINAPAN">
												<input type="hidden" name="booking_name[{{$penginapan}}]" id="booking_name{{$penginapan}}" class="form-control" value="{{$value->booking_name}}">
											</td>
											<td align="right"> 
												{!!number_format($value->booking_price)!!} 
												<input type="hidden" name="harga[{{$penginapan}}]" id="harga{{$penginapan}}" class="form-control" value="{{$value->booking_price}}">
											</td>
											<td>
												<input type="number" readonly style="text-align:right;" name="qty[{{$penginapan}}]" id="qty{{$penginapan}}" data-tiketid="{{$penginapan}}" data-harga="{{$value->booking_price}}" class="qty form-control" value="{!!(!empty($data_penginapan_order[$penginapan]->booking_qty) ? $data_penginapan_order[$penginapan]->booking_qty : 0)!!}">
											</td>
											<td align="right">
												<input type="text" style="text-align:right;" readonly name="subtotal[{{$penginapan}}]" id="subtotal{{$penginapan}}" class="subtotal form-control" value="{!!(!empty($data_penginapan_order[$penginapan]->booking_subtotal) ? number_format($data_penginapan_order[$penginapan]->booking_subtotal) : 0)!!}">
											</td>
											<td>
												<input class="btn btn-danger btn-sm" type="button" value="Delete" onclick="deleteRow(this)"/>
											</td>
										</tr>
										@php 
										$total_penginapan += @$data_penginapan_order[$penginapan]->booking_subtotal; 
										@endphp
										@endforeach
									@endif
									</tbody>
									<tfoot>
										<td colspan="3">Total</td>
										<td align="right">
											<input readonly type="text" style="text-align: right;" value="{!!number_format($total_penginapan)!!}" name="total" class="form-control" id="total">
										</td>
									</tfoot>
								</table>
							</div>
						</div>
						<h4>Transport</h4>
						<div class="row">
							<div class="col-md-12 table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th width="20%"> Voucher </th>
											<th width="10%"> Harga </th>
											<th width="10%"> Jumlah </th>
											<th width="30%" style="text-align:right"> Total </th>
											<th width="5%">Aksi</th>
										</tr>
									</thead>
									<tbody>
									@if(empty($data_transport_order))
										@foreach(@$data_transport_order as $transport => $value)
										<tr>
											<td>
												{{$value->booking_name}}
												<input type="hidden" name="booking_group[{{$transport}}]" id="booking_group{{$transport}}" class="form-control" value="TRANSPORT">
												<input type="hidden" name="booking_name[{{$transport}}]" id="booking_name{{$transport}}" class="form-control" value="{{$value->booking_name}}">
											</td>
											<td align="right"> 
												{!!number_format($value->booking_price)!!} 
												<input type="hidden" name="harga[{{$transport}}]" id="harga{{$transport}}" class="form-control" value="{{$value->booking_price}}">
											</td>
											<td>
												<input type="number" readonly style="text-align:right;" name="qty[{{$transport}}]" id="qty{{$transport}}" data-tiketid="{{$transport}}" data-harga="{{$value->booking_price}}" class="qty form-control" value="{!!(!empty($data_transport_order[$transport]->booking_qty) ? $data_transport_order[$transport]->booking_qty : 0)!!}">
											</td>
											<td align="right">
												<input type="text" style="text-align:right;" readonly name="subtotal[{{$transport}}]" id="subtotal{{$transport}}" class="subtotal form-control" value="{!!(!empty($data_transport_order[$transport]->booking_subtotal) ? number_format($data_transport_order[$transport]->booking_subtotal) : 0)!!}">
											</td>
											<td>
												<input class="btn btn-danger btn-sm" type="button" value="Delete" onclick="deleteRow(this)"/>
											</td>
										</tr>
										@php 
										$total_transport += @$data_transport_order[$transport]->booking_subtotal; 
										@endphp
										@endforeach
									@endif
									</tbody>
									<tfoot>
										<td colspan="3">Total</td>
										<td align="right">
											<input readonly type="text" style="text-align: right;" value="{!!number_format($total_transport)!!}" name="total" class="form-control" id="total">
										</td>
									</tfoot>
								</table>
							</div>
						</div>
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" align="center">
								<button id="btn-proses" class="btn btn-primary"><i class="fa fa-envelope"></i> Konfirmasi Tiket</button>
							</div>
						</div>
									

		        </form>
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
	
});


function pilihFasilitas(index,data){
	console.log(data);
}
function modalFasilitas(kode){
	$.ajax({
		url:"{{url('/')}}/admin/tiket/modalDataFasilitas",
		headers: {
        	'X-CSRF-TOKEN': '{{ csrf_token() }}'
	    },
	    data : {'group_kategori':kode},
	    type : 'GET',
	    success:function(data){
	        $('#div-modal').html(data);
	    }
	});
}
</script>
@endsection