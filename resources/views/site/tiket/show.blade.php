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

#mu-course-content .mu-course-content-area .mu-course-details .mu-latest-course-single .mu-latest-course-single-content ul li span:first-child {
    display: inline-block;
    min-width: 250px !important;
    float: left;
}

small, .small {
    font-size: 60% !important;
}
</style>
<section id="mu-page-breadcrumb">
   <div class="container">
	    <div class="row">
	        <div class="col-md-12">
		        <div class="mu-page-breadcrumb-area">
		           <h2>Status Tiket</h2>
		           <ol class="breadcrumb">
		            <li><a href="#">Home</a></li>            
		            <li class="active">Booking</li>
		          </ol>
         		</div>
       		</div>
     	</div>
   	</div>
</section>
<section id="mu-course-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="mu-course-content-area">
					<div class="row">
						<div class="col-md-12">
							
							<div class="mu-course-container mu-course-details">
				            	<div class="row">
									<div class="col-md-12">
										<div class="mu-latest-course-single">
											<div class="mu-latest-course-single-content">
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
										        <h2><a href="#">Status Tiket #{{@$invoice->it_kode_unik}} <small style="font-size: 50% !important;"> *) mohon untuk mengingat kode booking tiket</small></a></h2>
										        @if(!empty($invoice))
							                          <h4>Data Diri</h4>
							                          <ul>
							                            <li> <span>Kode Booking</span> <span>#{{$invoice->it_kode_unik}}</span></li>
							                            <li> <span>Tgl Booking</span> <span>{{$invoice->it_tanggal}}</span></li>
							                            <li> <span>Nama</span> <span>{{$invoice->it_pemesan}}</span></li>
							                            <li> <span>Email</span> <span>{{$invoice->it_email}}</span></li>
							                            <li> <span>Phone</span> <span>{{$invoice->it_telp}}</span></li>
							                            <li> <span>Total Tagihan</span> <span>Rp. {!!number_format(@$invoice->it_total_tagihan)!!},-</span></li>
							                            <li> <span>Metode Pembayaran</span> 
							                            	<span>{!!($invoice->it_jenis_pembayaran == 2 ? 'Transfer Bank' : 'Bayar cash di loket')!!}
							                            	</span>
							                            </li>
							                          </ul>
							                          <h4>Data Tiket</h4>
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
							                        <div class="row" style="margin-top: 10px;">
														<div class="col-md-12" align="center">
															@php
																$status = $invoice->status_tiket_id;
																// menentukan aksi yg bisa dilakukan oleh user saat booking tiket
															@endphp
															@if($status == 1)
																<a href="{{url('booking/')}}/{{$invoice->it_kode_unik}}/verifikasi" class="btn btn-primary"><i class="fa fa-check-circle"></i> Verifikasi Tiket</a>
															@elseif($status == 2)
																<a href="{{url('booking/')}}/{{$invoice->it_kode_unik}}/payment" class="btn btn-primary"> Konfirmasi Pembayaran</a>
															@elseif($status == 3)
																<a href="{{route('tiket.check')}}" class="btn btn-success"> Cek Status TIket</a>
															@elseif($status == 4)
																<a target="_blank" href="{{url('tiket/')}}/{{$invoice->it_kode_unik}}/cetak" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Cetak Tiket</a>
															@else
																<a href="{{url('tiket/')}}/{{$invoice->it_kode_unik}}/payment" class="btn btn-primary"><i class="fa fa-money"></i> Cek Status Tiket</a>
															@endif
														</div>
													</div>
										        @else
										        	<input type="text" name="kode" id="kode" value="{{@$kode}}" class="form-control" placeholder="Kode Booking Tanpa (#)">
										        	<div class="row" style="margin-top: 10px;">
														<div class="col-md-12" align="center">
															<button id="btn-search" class="btn btn-success"><i class="fa fa-search"></i> Cek Status</button>
														</div>
													</div>
										        @endif
											</div>
										</div> 
									</div>
				                </div>
				       
				            </div>
	            
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
		$("#btn-search").on('click', function () {

	      	if($('#kode').val() !== ""){
	            window.location.href = '{{url("tiket/")}}/check/'+$('#kode').val();
	        }else{
	        	window.location.href = '{{url("tiket/")}}/check/';
	        }
	    });
	});
</script>
@endsection