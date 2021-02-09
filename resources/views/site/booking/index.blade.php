@extends('site.template')
@section('navbar')
  @include('site/navbar')
@endsection
@section('content')
<style type="text/css">
  #mu-course-content {
    background-color: #f8f8f8;
    display: inline;
    float: left;
    padding: 30px 0 !important;
    width: 100%;
}

#mu-course-content .mu-course-content-area .mu-sidebar .mu-single-sidebar .mu-sidebar-catg {
	padding-left: 0px !important;
	font-size: 14px !important; 
}

.mu-sidebar-catg>li{
	padding: 10px;
}
</style>
<section id="mu-page-breadcrumb">
   <div class="container">
	    <div class="row">
	        <div class="col-md-12">
		        <div class="mu-page-breadcrumb-area">
		           <h2>Pemesanan</h2>
		           <ol class="breadcrumb">
		            <li><a href="#">Home</a></li>            
		            <li class="active">Pemesanan</li>
		          </ol>
         		</div>
       		</div>
     	</div>
   	</div>
</section>
<section id="mu-course-content">
	@php
		$data_booking = @$data['booking'];
		$data_tiket_order = (array) @$data['tiket'];
		$data_kuliner_order = (array) @$data['kuliner'];
		$data_penginapan_order = (array) @$data['penginapan'];
		$data_transport_order = (array) @$data['transport'];
		$total_tiket = 0; $total_kuliner = 0; $total_penginapan = 0; $total_transport = 0;
	@endphp
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="mu-course-content-area">
					<div class="row">
						<div class="col-md-3">
							<!-- start sidebar -->
							<aside class="mu-sidebar">
								<!-- start single sidebar -->
								<div class="mu-single-sidebar">
									<h4>Cara Pemesanan On-line</h4>
									<ul class="mu-sidebar-catg">
										<li><i class="fa fa-book"></i> Lengkapi Form Isian Data</li>
										<li><i class="fa fa-envelope"></i> Verifikasi Tiket</li>
										<li><i class="fa fa-money"></i> Verifikasi Bukti Bayar</li>
										<li><i class="fa fa-file-pdf-o"></i> Cetak Tiket</li>
										<li><i class="fa fa-check-circle"></i> Selesai</li>
									</ul>
								</div>
								<!-- end single sidebar -->
							<!-- start single sidebar -->
							</aside>
				        </div>
						<div class="col-md-9">
							<form role="form" id="form-data" name="form-data" method="POST" action="{{url('/')}}/booking/proses">
								<!-- form reqiure laravel -->
								<input type="hidden" name="_method" value="POST">
								@csrf
								<!-- form require laravel end -->
								<div class="mu-course-container mu-course-details">
					                <div class="row">
					                  	<div class="col-md-12">
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
									        @endif
											<div class="mu-latest-course-single">
												<div class="mu-latest-course-single-content">
													<h4>Data Diri</h4>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label>Nama</label>
																<input type="text" name="nama" id="nama" class="form-control" required="" value="{{@$data_booking->nama}}">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Email</label>
																<input type="email" name="email" id="email" class="form-control" required="" value="{{@$data_booking->email}}">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Phone</label>
																<input type="text" name="telp" id="telp" class="form-control" required="" value="{{@$data_booking->telp}}">
															</div>
														</div>
													</div>
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
													<div class="row col-md-12">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																	<tr>
																		<th width="20%"> Tiket </th>
																		<th width="10%"> Harga </th>
																		<th width="10%"> Jumlah </th>
																		<th width="30%" style="text-align:right"> Total </th>
																		<th width="5%">Aksi</th>
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
																			<input type="number" readonly style="text-align:right;" name="qty[{{$value->mt_id}}]" id="qty{{$value->mt_id}}" data-tiketid="{{$value->mt_id}}" data-harga="{{$value->mt_harga}}" class="qty form-control" value="{!!(!empty($data_tiket_order[$value->mt_id]->booking_qty) ? $data_tiket_order[$value->mt_id]->booking_qty : 0)!!}">
																		</td>
																		<td align="right">
																			<input type="text" style="text-align:right;" readonly name="subtotal[{{$value->mt_id}}]" id="subtotal{{$value->mt_id}}" class="subtotal form-control" value="{!!(!empty($data_tiket_order[$value->mt_id]->booking_subtotal) ? number_format($data_tiket_order[$value->mt_id]->booking_subtotal) : 0)!!}">
																		</td>
																		<td>
																			<input class="btn btn-danger btn-sm" type="button" value="Delete" data-booking="Tiket {{$value->mt_nama_tiket}}" data-key="TIKET-{{$value->mt_id}}" onclick="deleteRow(this)"/>
																		</td>
																	</tr>
																	@php $total_tiket += @$data_tiket_order[$value->mt_id]->booking_subtotal; @endphp
																	@endforeach
																</tbody>
																<tfoot>
																	<td colspan="3">Total</td>
																	<td align="right">
																		<input readonly type="text" style="text-align: right;" value="{!!number_format($total_tiket)!!}" name="total" class="form-control" id="total-tiket">
																	</td>
																</tfoot>
															</table>
														</div>
													</div>
													<h4>Kuliner</h4>
													<div class="row col-md-12">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																	<tr>
																		<th width="20%"> Tiket </th>
																		<th width="10%"> Harga </th>
																		<th width="10%"> Jumlah </th>
																		<th width="30%" style="text-align:right"> Total </th>
																		<th width="5%">Aksi</th>
																	</tr>
																</thead>
																<tbody>
																	@foreach($data_kuliner_order as $kuliner => $value)
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
																			<input class="btn btn-danger btn-sm" type="button" value="Delete" data-booking="{{$value->booking_name}}" data-key="KULINER-{{$kuliner}}" onclick="deleteRow(this)"/>
																		</td>
																	</tr>
																	@php 
																	$total_kuliner += @$data_kuliner_order[$kuliner]->booking_subtotal; 
																	@endphp
																	@endforeach
																</tbody>
																<tfoot>
																	<td colspan="3">Total</td>
																	<td align="right">
																		<input readonly type="text" style="text-align: right;" value="{!!number_format($total_kuliner)!!}" name="total" class="form-control" id="total-kuliner">
																	</td>
																</tfoot>
															</table>
														</div>
													</div>
													<h4>Penginapan</h4>
													<div class="row col-md-12">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																	<tr>
																		<th width="20%"> Tiket </th>
																		<th width="10%"> Harga </th>
																		<th width="10%"> Jumlah </th>
																		<th width="30%" style="text-align:right"> Total </th>
																		<th width="5%">Aksi</th>
																	</tr>
																</thead>
																<tbody>
																	@foreach($data_penginapan_order as $penginapan => $value)
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
																			<input class="btn btn-danger btn-sm" type="button" value="Delete" data-booking="{{$value->booking_name}}" data-key="PENGINAPAN-{{$penginapan}}" onclick="deleteRow(this)"/>
																		</td>
																	</tr>
																	@php 
																	$total_penginapan += @$data_penginapan_order[$penginapan]->booking_subtotal; 
																	@endphp
																	@endforeach
																</tbody>
																<tfoot>
																	<td colspan="3">Total</td>
																	<td align="right">
																		<input readonly type="text" style="text-align: right;" value="{!!number_format($total_penginapan)!!}" name="total" class="form-control" id="total-penginapan">
																	</td>
																</tfoot>
															</table>
														</div>
													</div>
													<h4>Transport</h4>
													<div class="row col-md-12">
														<div class="table-responsive">
															<table class="table table-striped">
																<thead>
																	<tr>
																		<th width="20%"> Tiket </th>
																		<th width="10%"> Harga </th>
																		<th width="10%"> Jumlah </th>
																		<th width="30%" style="text-align:right"> Total </th>
																		<th width="5%">Aksi</th>
																	</tr>
																</thead>
																<tbody>
																@foreach($data_transport_order as $transport => $value)
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
																			<input class="btn btn-danger btn-sm" type="button" value="Delete" data-booking="{{$value->booking_name}}" data-key="TRANSPORT-{{$transport}}" onclick="deleteRow(this)"/>
																		</td>
																	</tr>
																@php 
																$total_transport += @$data_transport_order[$transport]->booking_subtotal; 
																@endphp
																@endforeach
																</tbody>
																<tfoot>
																	<td colspan="3">Total</td>
																	<td align="right">
																		<input readonly type="text" style="text-align: right;" value="{!!number_format($total_transport)!!}" name="total" class="form-control" id="total-transport">
																	</td>
																</tfoot>
															</table>
														</div>
													</div>
													<h4>Metode Pembayaran</h4>
													<div class="row">
														<div class="col-md-6">
															<div class="form-check">
																<input class="form-check-input" type="radio" name="metode_bayar" id="metode_bayar_1" value="1" {!!((@$data_booking->metode_bayar == 1) ? 'checked' : '')!!}>
																<label class="form-check-label" for="metode_bayar_1">
																	Bayar cash di loket
																</label>
															</div>
														</div>
													<div class="col-md-6">
														<div class="form-check">
															<input class="form-check-input" type="radio" name="metode_bayar" id="metode_bayar_2" value="2" {!!((@$data_booking->metode_bayar == 2) ? 'checked' : '')!!}>
															<label class="form-check-label" for="metode_bayar_2">
																Transfer Bank
															</label>
														</div>
													</div>
													</div>
													<div class="row" style="margin-top: 10px;">
														<div class="col-md-12" align="center">
															<button id="btn-proses" class="btn btn-primary"><i class="fa fa-envelope"></i> Konfirmasi Tiket</button>
														</div>
													</div>
												</div>
											</div> 
					                  	</div>                                   
					                </div>
					            </div>
					        </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('script')
<script type="text/javascript">
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
			
			//change total order price
			var total = 0;
			$('.subtotal').each(function() {
				total += parseFloat(plainNumber($(this).val()));
				$('#total').val(total);
			});
			var sanitized = $('#total').val().replace(/[^-.0-9]/g, '');
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
			$('#total').val(normal);
		});

	});

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
  		var confirm = window.confirm("Hapus Item "+$(btn).attr('data-booking')+'?');
  		$.ajax({
  			url:"{{url('booking/item/delete')}}",
  			data:{keyid:$(btn).attr('data-key')},
  			dataType:"JSON",
  			success:function(data){
  				if(data.success == 1){
	  				toast_success('Berhasil',data.msg);
	  				var row = btn.parentNode.parentNode;
					row.parentNode.removeChild(row);
  				}else{
					toast_error('Gagal',data.msg);
  				}
  				getCartItem();
  				getSubtotal();
  			},error:function(error){
  				toast_error('Gagal','Terjadi kesalahan sistem');
  				console.log(error.XMLHttpRequest);
  			}
  		});
		/**/
	}

	function getSubtotal(){
		var sanitized = $('#total-tiket').val().replace(/[^-.0-9]/g, '');
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
        $('#total-tiket').val(normal);
		
		var sanitized = $('#total-kuliner').val().replace(/[^-.0-9]/g, '');
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
        $('#total-kuliner').val(normal);

		var sanitized = $('#total-penginapan').val().replace(/[^-.0-9]/g, '');
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
        $('#total-penginapan').val(normal);

		var sanitized = $('#total-transport').val().replace(/[^-.0-9]/g, '');
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
        $('#total-transport').val(normal);
	}
</script>
@endsection