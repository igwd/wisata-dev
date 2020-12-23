<table>
	<thead>
		<th>
			<td>Verifikasi Tiket Anda</td>
		</th>
	</thead>
	<tbody>
		<tr>
			<td>Tanggal Booking</td>
			<td>:</td>
			<td>{{$data->it_tanggal}}</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td>{{$data->it_pemesan}}</td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td>{{$data->it_email}}</td>
		</tr>
		<tr>
			<td>No. Telp</td>
			<td>:</td>
			<td>{{$data->it_telp}}</td>
		</tr>
		<tr>
			<td>Detail Pesanan</td>
			<td>:</td>
			@php
			$detail = explode('@',$data->it_keterangan);
			@endphp
			<td>
				@foreach($detail as $det =>  $value)
				{{$value}}<br>
				@endforeach
			</td>
		</tr>
		<tr>
			<td>Total</td>
			<td>:</td>
			<td>Rp. {!! number_format($data->it_total_tagihan)!!}</td>
		</tr>
	</tbody>
</table>
<br><br>
<a href="{{$url_verifikasi}}">Verifikasi Pesanan</a>