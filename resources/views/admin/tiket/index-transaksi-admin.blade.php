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
	</div>
	<div class="row">
		<div class="col-md-8 card">
		  	<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<form role="form" id="form-data" name="form-data">
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
													<input type="hidden" name="booking_id[{{$value->mt_id}}]" id="booking_id{{$value->mt_id}}" class="form-control" value="{{$value->mt_id}}">
													<input type="hidden" name="booking_group[{{$value->mt_id}}]" id="booking_group{{$value->mt_id}}" class="form-control" value="TIKET">
													<input type="hidden" name="booking_name[{{$value->mt_id}}]" id="booking_name{{$value->mt_id}}" class="form-control" value="{{$value->mt_nama_tiket}}">
												</td>
												<td align="right"> 
													{!!number_format($value->mt_harga)!!} 
													<input type="hidden" style="text-align:right;" name="harga[{{$value->mt_id}}]" id="harga{{$value->mt_id}}" class="form-control" value="{{$value->mt_harga}}">
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
									</table>
								</div>
								<input type="hidden" name="index" id="index" value="3">
							</div>
							<a href="javascript:void(0)" onclick="toggleKuliner()"><h4>Kuliner</h4></a>
							<div id="div-kuliner" class="row">
								<div class="col-md-12 table-responsive">
									<table id="table-kuliner" class="table table-striped">
										<thead>
											<tr>
												<th width="20%"> Voucher </th>
												<th width="20%"> Harga </th>
												<th width="10%"> Jumlah </th>
												<th width="20%" style="text-align:right"> Total </th>
												<th width="5%">Aksi</th>
											</tr>
										</thead>
										<tbody>
										@if(empty($data_kuliner_order))
											<tr>
												<td>
													<input type="hidden" name="booking_id[]" id="booking_id1" class="form-control booking-id" value="">
													<input type="hidden" name="booking_group[]" id="booking_group1" class="form-control" value="KULINER">
													<input type="text" readonly onclick="modalFasilitas(1,'TEMPAT_MAKAN')" name="booking_name[]" id="booking_name1" class="form-control" value="{{$value->booking_name}}">
												</td>
												<td align="right"> 
													<input type="number" readonly style="text-align:right;" name="harga[]" id="harga1" class="form-control" value="{{$value->booking_price}}">
												</td>
												<td>
													<input type="number" readonly style="text-align:right;" name="qty[]" id="qty1" data-tiketid="" data-harga="" class="qty-kuliner form-control" value="">
												</td>
												<td align="right">
													<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal1" class="subtotal form-control" value="">
												</td>
												<td>
													<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)"/>
												</td>
											</tr>
										@else
											@foreach(@$data_kuliner_order as $kuliner => $value)
											<tr>
												<td>
													{{$value->booking_name}}
													<input type="hidden" name="booking_id[]" id="booking_id{{$kuliner}}" class="form-control booking-id" value="{{$value->id}}">
													<input type="hidden" name="booking_group[{{$kuliner}}]" id="booking_group{{$kuliner}}" class="form-control" value="KULINER">
													<input type="hidden" name="booking_name[{{$kuliner}}]" id="booking_name{{$kuliner}}" class="form-control" value="{{$value->booking_name}}">
												</td>
												<td align="right"> 
													{!!number_format($value->booking_price)!!} 
													<input type="hidden" style="text-align:right;" name="harga[{{$kuliner}}]" id="harga{{$kuliner}}" class="form-control" value="{{$value->booking_price}}">
												</td>
												<td>
													<input type="number" readonly style="text-align:right;" name="qty[{{$kuliner}}]" id="qty{{$kuliner}}" data-tiketid="{{$kuliner}}" data-harga="{{$value->booking_price}}" class="qty-kuliner form-control" value="{!!(!empty($data_kuliner_order[$kuliner]->booking_qty) ? $data_kuliner_order[$kuliner]->booking_qty : 0)!!}">
												</td>
												<td align="right">
													<input type="text" style="text-align:right;" readonly name="subtotal[{{$kuliner}}]" id="subtotal{{$kuliner}}" class="subtotal form-control" value="{!!(!empty($data_kuliner_order[$kuliner]->booking_subtotal) ? number_format($data_kuliner_order[$kuliner]->booking_subtotal) : 0)!!}">
												</td>
												<td>
													<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)"/>
												</td>
											</tr>
											@php 
											$total_kuliner += @$data_kuliner_order[$kuliner]->booking_subtotal; 
											@endphp
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
							</div>
							<a href="javascript:void(0)" onclick="togglePenginapan()"><h4>Penginapan</h4></a>
							<div id="div-penginapan" class="row">
								<div class="col-md-12 table-responsive">
									<table id="table-penginapan" class="table table-striped">
										<thead>
											<tr>
												<th width="20%"> Voucher </th>
												<th width="20%"> Harga </th>
												<th width="10%"> Jumlah </th>
												<th width="20%" style="text-align:right"> Total </th>
												<th width="5%">Aksi</th>
											</tr>
										</thead>
										<tbody>
										@if(empty($data_penginapan_order))
											<tr>
												<td>
													<input type="hidden" name="booking_id[]" id="booking_id2" class="form-control booking-id" value="">
													<input type="hidden" name="booking_group[]" id="booking_group2" class="form-control" value="PENGINAPAN">
													<input type="text" readonly onclick="modalFasilitas(2,'PENGINAPAN')" name="booking_name[]" id="booking_name2" class="form-control" value="{{$value->booking_name}}">
												</td>
												<td align="right"> 
													<input type="number" readonly style="text-align:right;" name="harga[]" id="harga2" class="form-control" value="{{$value->booking_price}}">
												</td>
												<td>
													<input type="number" readonly style="text-align:right;" name="qty[]" id="qty2" data-tiketid="" data-harga="" class="qty-penginapan form-control" value="">
												</td>
												<td align="right">
													<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal2" class="subtotal form-control" value="">
												</td>
												<td>
													<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)"/>
												</td>
											</tr>
										@else
											@foreach(@$data_penginapan_order as $penginapan => $value)
											<tr>
												<td>
													{{$value->booking_name}}
													<input type="hidden" name="booking_id[]" id="booking_id{{$penginapan}}" class="form-control booking-id" value="{{$value->id}}">
													<input type="hidden" name="booking_group[{{$penginapan}}]" id="booking_group{{$penginapan}}" class="form-control" value="PENGINAPAN">
													<input type="hidden" name="booking_name[{{$penginapan}}]" id="booking_name{{$penginapan}}" class="form-control" value="{{$value->booking_name}}">
												</td>
												<td align="right"> 
													{!!number_format($value->booking_price)!!} 
													<input type="hidden" style="text-align:right;" name="harga[{{$penginapan}}]" id="harga{{$penginapan}}" class="form-control" value="{{$value->booking_price}}">
												</td>
												<td>
													<input type="number" readonly style="text-align:right;" name="qty[{{$penginapan}}]" id="qty{{$penginapan}}" data-tiketid="{{$penginapan}}" data-harga="{{$value->booking_price}}" class="qty-penginapan form-control" value="{!!(!empty($data_penginapan_order[$penginapan]->booking_qty) ? $data_penginapan_order[$penginapan]->booking_qty : 0)!!}">
												</td>
												<td align="right">
													<input type="text" style="text-align:right;" readonly name="subtotal[{{$penginapan}}]" id="subtotal{{$penginapan}}" class="subtotal form-control" value="{!!(!empty($data_penginapan_order[$penginapan]->booking_subtotal) ? number_format($data_penginapan_order[$penginapan]->booking_subtotal) : 0)!!}">
												</td>
												<td>
													<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)"/>
												</td>
											</tr>
											@php 
											$total_penginapan += @$data_penginapan_order[$penginapan]->booking_subtotal; 
											@endphp
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
							</div>
							<a href="javascript:void(0)" onclick="toggleTransport()"><h4>Transport</h4></a>
							<div id="div-transport" class="row">
								<div class="col-md-12 table-responsive">
									<table id="table-transport" class="table table-striped">
										<thead>
											<tr>
												<th width="20%"> Voucher </th>
												<th width="20%"> Harga </th>
												<th width="10%"> Jumlah </th>
												<th width="20%" style="text-align:right"> Total </th>
												<th width="5%">Aksi</th>
											</tr>
										</thead>
										<tbody>
										@if(empty($data_transport_order))
											<tr>
												<td>
													<input type="hidden" name="booking_id[]" id="booking_id3" class="form-control booking-id" value="">
													<input type="hidden" name="booking_group[]" id="booking_group3" class="form-control" value="PENGINAPAN">
													<input type="text" readonly onclick="modalFasilitas(3,'TRANSPORT')" name="booking_name[]" id="booking_name3" class="form-control" value="{{$value->booking_name}}">
												</td>
												<td align="right"> 
													<input type="number" readonly style="text-align:right;" name="harga[]" id="harga3" class="form-control" value="{{$value->booking_price}}">
												</td>
												<td>
													<input type="number" readonly style="text-align:right;" name="qty[]" id="qty3" data-tiketid="" data-harga="" class="qty-transport form-control" value="">
												</td>
												<td align="right">
													<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal3" class="subtotal form-control" value="">
												</td>
												<td>
													<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)"/>
												</td>
											</tr>
										@else
											@foreach(@$data_transport_order as $transport => $value)
											<tr>
												<td>
													{{$value->booking_name}}
													<input type="hidden" name="booking_id[]" id="booking_id{{$transport}}" class="form-control booking-id" value="{{$value->id}}">
													<input type="hidden" name="booking_group[{{$transport}}]" id="booking_group{{$transport}}" class="form-control" value="TRANSPORT">
													<input type="hidden" name="booking_name[{{$transport}}]" id="booking_name{{$transport}}" class="form-control" value="{{$value->booking_name}}">
												</td>
												<td align="right"> 
													{!!number_format($value->booking_price)!!} 
													<input type="hidden" style="text-align:right;" name="harga[{{$transport}}]" id="harga{{$transport}}" class="form-control" value="{{$value->booking_price}}">
												</td>
												<td>
													<input type="number" readonly style="text-align:right;" name="qty[{{$transport}}]" id="qty{{$transport}}" data-tiketid="{{$transport}}" data-harga="{{$value->booking_price}}" class="qty-transport form-control" value="{!!(!empty($data_transport_order[$transport]->booking_qty) ? $data_transport_order[$transport]->booking_qty : 0)!!}">
												</td>
												<td align="right">
													<input type="text" style="text-align:right;" readonly name="subtotal[{{$transport}}]" id="subtotal{{$transport}}" class="subtotal form-control" value="{!!(!empty($data_transport_order[$transport]->booking_subtotal) ? number_format($data_transport_order[$transport]->booking_subtotal) : 0)!!}">
												</td>
												<td>
													<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)"/>
												</td>
											</tr>
											@php 
											$total_transport += @$data_transport_order[$transport]->booking_subtotal; 
											@endphp
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
							</div>
				        </form>
					</div>
				</div>				
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="card">
				<div class="card-body">
					<h4>Kasir</h4>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" readonly style="text-align: right; padding-right: 15px;" class="datepicker form-control" id="tanggal" name="tanggal" value="{!!(!empty($booking->tanggal) ? $data_booking->tanggal : date('Y-m-d')) !!}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Total Transaksi</label>
								<input type="text" readonly style="text-align: right; padding-right: 15px;" class="form-control" id="total-tagihan" name="total-tagihan" value="{!!(!empty($booking->it_total_tagihan) ? $data_booking->it_total_tagihan : 0 )!!}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Bayar</label>
								<input type="text" style="text-align: right; padding-right: 15px;" class="form-control" id="bayar" name="bayar" value="">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Kembali</label>
								<input type="text" readonly style="text-align: right; padding-right: 15px;" class="form-control" id="total-kembali" name="total-kembali" value="">
							</div>
						</div>
					</div>
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-12">
							<div class="group-btn pull-right">
								<a class="btn btn-danger btn-sm" href=""><i class="fa fa-refresh"></i> Reset</a>
								<button id="btn-proses" class="btn btn-primary btn-sm" disabled><i class="fa fa-money"></i> Bayar</button>
								<button id="btn-cetak" class="btn btn-danger btn-sm" disabled><i class="fa fa-file-pdf"></i> Cetak Tiket</button>
							</div>
						</div>
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
$(document).ready(function(){
	$('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
	    startDate: '-3d',
	    todayHighlight:true,
	    autoclose:true
	});

	$('.qty').on('change keyup', function() {
		//console.log($(this).val(),$(this).attr('data-harga'));
		var id = $(this).attr('data-tiketid');
		var harga = $(this).attr('data-harga');
		const subtotal = parseInt($(this).val())*parseFloat(harga);

		//change subtotal format
		$('#subtotal'+id).val(subtotal);
		var sanitized = $('#subtotal'+id).val().replace(/[^-.0-9]/g, '');
		// Remove non-leading minus signs
		sanitized = sanitized.replace(/(.)-+/g, '$1');
		// Remove the first point if there is more than one
		sanitized = sanitized.replace(/\.(?=.*\.)/g, '');
		// Update value
		var value = sanitized,
		plain = plainNumber(value),
		reversed = reverseNumber(plain),
		reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
		normal = reverseNumber(reversedWithDots);
		$('#subtotal'+id).val(normal);

		hitungTrx();
	});

	$("#bayar").on('change keyup',function(){
		var sanitized = $(this).val().replace(/[^-.0-9]/g, '');
		// Remove non-leading minus signs
		sanitized = sanitized.replace(/(.)-+/g, '$1');
		// Remove the first point if there is more than one
		sanitized = sanitized.replace(/\.(?=.*\.)/g, '');
		// Update value
		var value = sanitized,
		plain = plainNumber(value),
		reversed = reverseNumber(plain),
		reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
		normal = reverseNumber(reversedWithDots);
		$(this).val(normal);

		//kembalian
		var total = parseFloat(plainNumber($('#total-tagihan').val()));
		var bayar = parseFloat(plainNumber($(this).val()));
		if(total <= bayar){
			kembalian = bayar - total;
			$('#total-kembali').val(kembalian);
			var sanitized = $('#total-kembali').val().replace(/[^-.0-9]/g, '');
			// Remove non-leading minus signs
			sanitized = sanitized.replace(/(.)-+/g, '$1');
			// Remove the first point if there is more than one
			sanitized = sanitized.replace(/\.(?=.*\.)/g, '');
			// Update value
			var value = sanitized,
			plain = plainNumber(value),
			reversed = reverseNumber(plain),
			reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
			normal = reverseNumber(reversedWithDots);
			$('#total-kembali').val(normal);

			$('#btn-proses').prop('disabled', false);
		}else{
			$('#btn-proses').prop('disabled', true);
		}
	});

	$('#btn-proses').click(function(e){
		e.preventDefault();
		$('#form-data').ajaxSubmit({
			url:"{{url('admin/tiket/proses')}}",
			data:{'tanggal':$('#tanggal').val()},
			type:"POST",
			dataType:"JSON",
			success:function(data){
				console.log(data);
				$('.alert').removeClass('alert-success alert-danger');
		        $('.alert').css('display','none');
		        $('.alert').addClass(data.class);
		        $('.alert').html(data.text);
		        $('.alert').css('display','block');
		        if(data.kode != "-"){
		        	$('#btn-cetak').prop('disabled',false);
			        $('#btn-cetak').attr('data-kode',data.kode);
		        }
			}
		});
	});

	$('#btn-cetak').click(function(){
		kode = $(this).attr('data-kode');
		window.open(
		  "{{url('tiket')}}/"+kode+"/cetak",
		  '_blank'
		);
	});

});

function prosesTransaksi(){

}

function hitungTrx(){
	//change total order price
	var total = 0;
	$('.subtotal').each(function() {
		if($(this).val() != ""){
			total += parseFloat(plainNumber($(this).val()));
			$('#total-tagihan').val(total);
		}
	});
	var sanitized = $('#total-tagihan').val().replace(/[^-.0-9]/g, '');
	// Remove non-leading minus signs
	sanitized = sanitized.replace(/(.)-+/g, '$1');
	// Remove the first point if there is more than one
	sanitized = sanitized.replace(/\.(?=.*\.)/g, '');
	// Update value
	var value = sanitized,
	plain = plainNumber(value),
	reversed = reverseNumber(plain),
	reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
	normal = reverseNumber(reversedWithDots);
	$('#total-tagihan').val(normal);
}

//currencynumber start
// Catch all events related to changes
function reverseNumber(input) {
	return [].map.call(input, function(x) {
	  return x;
	}).reverse().join(''); 
}

function plainNumber(number) {
	return number.split('.').join('');
}

function deleteRow(btn) {
	var row = btn.parentNode.parentNode;
	row.parentNode.removeChild(row);
}

function modalFasilitas(index,kode){
	var selected = [];
	$('.booking-id').each(function(key){
		if($(this).val() != ""){
			selected.push($(this).val());
		}
	});
	console.log(selected);
	$.ajax({
		url:"{{url('/')}}/admin/tiket/modalDataFasilitas",
		headers: {
        	'X-CSRF-TOKEN': '{{ csrf_token() }}'
	    },
	    data : {'group_kategori':kode,'index':index, 'selected':selected},
	    type : 'GET',
	    success:function(data){
	        $('#div-modal').html(data);
	    }
	});
}

function addRowKuliner(index){
    var entity = '<tr>'+
                    '<td>'+
                        '<input type="hidden" name="booking_id[]" id="booking_id'+index+'" class="form-control booking-id" value="">'+
                        '<input type="hidden" name="booking_group[]" id="booking_group'+index+'" class="form-control" value="KULINER">'+
                        '<input type="text" readonly onclick="modalFasilitas('+index+',\'TEMPAT_MAKAN\')" name="booking_name[]" id="booking_name'+index+'" class="form-control" value="">'+
                    '</td>'+
                    '<td align="right">'+ 
                        '<input type="number" readonly style="text-align:right;" name="harga[]" id="harga'+index+'" class="form-control" value="">'+
                    '</td>'+
                    '<td>'+
                        '<input type="number" readonly style="text-align:right;" name="qty[]" id="qty'+index+'" data-tiketid="" data-harga="" class="qty-kuliner form-control" value="">'+
                    '</td>'+
                    '<td align="right">'+
                        '<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal'+index+'" class="subtotal form-control" value="">'+
                    '</td>'+
                    '<td>'+
                        '<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)">'+
                    '</td>'+
                '</tr>';
    $('#table-kuliner tbody').append(entity);
}

function addRowPenginapan(index){
    var entity = '<tr>'+
                    '<td>'+
                        '<input type="hidden" name="booking_id[]" id="booking_id'+index+'" class="form-control booking-id" value="">'+
                        '<input type="hidden" name="booking_group[]" id="booking_group'+index+'" class="form-control" value="KULINER">'+
                        '<input type="text" readonly onclick="modalFasilitas('+index+',\'TEMPAT_MAKAN\')" name="booking_name[]" id="booking_name'+index+'" class="form-control" value="">'+
                    '</td>'+
                    '<td align="right">'+ 
                        '<input type="number" readonly style="text-align:right;" name="harga[]" id="harga'+index+'" class="form-control" value="">'+
                    '</td>'+
                    '<td>'+
                        '<input type="number" readonly style="text-align:right;" name="qty[]" id="qty'+index+'" data-tiketid="" data-harga="" class="qty-penginapan form-control" value="">'+
                    '</td>'+
                    '<td align="right">'+
                        '<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal'+index+'" class="subtotal form-control" value="">'+
                    '</td>'+
                    '<td>'+
                        '<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)">'+
                    '</td>'+
                '</tr>';
    $('#table-penginapan tbody').append(entity);
}

function addRowTransport(index){
    var entity = '<tr>'+
                    '<td>'+
                        '<input type="hidden" name="booking_id[]" id="booking_id'+index+'" class="form-control booking-id" value="">'+
                        '<input type="hidden" name="booking_group[]" id="booking_group'+index+'" class="form-control" value="KULINER">'+
                        '<input type="text" readonly onclick="modalFasilitas('+index+',\'TEMPAT_MAKAN\')" name="booking_name[]" id="booking_name'+index+'" class="form-control" value="">'+
                    '</td>'+
                    '<td align="right">'+ 
                        '<input type="number" readonly style="text-align:right;" name="harga[]" id="harga'+index+'" class="form-control" value="">'+
                    '</td>'+
                    '<td>'+
                        '<input type="number" readonly style="text-align:right;" name="qty[]" id="qty'+index+'" data-tiketid="" data-harga="" class="qty-transport form-control" value="">'+
                    '</td>'+
                    '<td align="right">'+
                        '<input type="text" readonly style="text-align:right;" readonly name="subtotal[]" id="subtotal'+index+'" class="subtotal form-control" value="">'+
                    '</td>'+
                    '<td>'+
                        '<input class="btn btn-danger btn-sm" type="button" value="X" onclick="deleteRow(this)">'+
                    '</td>'+
                '</tr>';
    $('#table-transport tbody').append(entity);
}

function toggleKuliner(){
	$("#div-kuliner").toggle();
}
function togglePenginapan(){
	$("#div-penginapan").toggle();
}
function toggleTransport(){
	$("#div-transport").toggle();
}
</script>
@endsection