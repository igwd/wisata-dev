<html>
<head>
	<title>{{$invoice->it_kode_unik}}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<h4>Tiket #{{$invoice->it_kode_unik}}</h4>
 	<table class="table table-striped">
 		<tr>
 			<td>Kode Booking</td><td>{{$invoice->it_kode_unik}}</td>
 		</tr>
 		<tr>
 			<td>Tanggal Booking</td><td>{{$invoice->it_tanggal}}</td>
 		</tr>
 		<tr>
 			<td>Nama</td><td>{{$invoice->it_pemesan}}</td>
 		</tr>
 		<tr>
 			<td>Email</td><td>{{$invoice->it_email}}</td>
 		</tr>
 		<tr>
 			<td>No. Telp</td><td>{{$invoice->it_telp}}</td>
 		</tr>

 	</table>
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th width="20%"> Tiket </th>
				<th width="10%"> Harga </th>
				<th width="10%"> Jumlah </th>
				<th width="30%" style="text-align:right"> Total </th>
			</tr>
		</thead>
      	<tbody>
      		@php
      			$detail_tiket = @$invoice->invoice_tiket_detail;
      		@endphp
      		@if(!empty($detail_tiket))
      		@foreach($detail_tiket as $key => $detail)
      		<tr>
      			<td><small>[{{$detail->booking_group}}]</small> {{$detail->booking_name}}</td>
      			<td align="right">{!!number_format($detail->itd_nominal)!!}</td>
      			<td align="right">{{$detail->itd_qty}}</td>
      			<td align="right">{!!number_format($detail->itd_subtotal)!!}</td>
      		</tr>
      		@endforeach
      		@endif
      	</tbody>
	</table>
	<h4>Bukti Bayar</h4>
	@if($invoice->it_jenis_pembayaran == 2)
	<div style="margin-top: 30px;">
		<img src="{{url('/')}}/{{$invoice->file_bukti}}" width="50%">
 	</div>
 	@else
 		[ PEMBAYARAN CASH MELALUI LOKET ]
 	@endif
</body>
</html>