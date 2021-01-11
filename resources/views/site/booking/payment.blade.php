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
		           <h2>Booking Area</h2>
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
						<div class="col-md-3">
							<!-- start sidebar -->
							<aside class="mu-sidebar">
				                <!-- start single sidebar -->
				                <div class="mu-single-sidebar">
				                  <h4>Cara Pemesanan On-line</h4>
				                  <ul class="mu-sidebar-catg">
				                    <li>{!!(@$invoice->status_tiket_id >= 1 ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-book"></i>')!!} Lengkapi Form Isian Data</li>
				                    <li>{!!(@$invoice->status_tiket_id >= 1 ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-envelope"></i>')!!} Verifikasi Tiket</li>
				                    @if(@$invoice->it_jenis_pembayaran == 2)
				                    <li><i class="fa fa-money"></i> Verifikasi Bukti Bayar</li>
				                    <li><i class="fa fa-file-pdf-o"></i> Cetak Tiket</li>
				                    @endif
				                    <li><i class="fa fa-check-circle"></i> Selesai</li>
				                  </ul>
				                </div>
				                <!-- end single sidebar -->
				                <!-- start single sidebar -->
				            </aside>
				        </div>
						<div class="col-md-9">
							
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

										          <h2><a href="#">Payment Tiket #{{@$invoice->it_kode_unik}}</a></h2>
						                          <h4>Data Diri</h4>
						                          <ul>
						                            <li> <span>Kode Booking</span> <span>#{{@$invoice->it_kode_unik}}</span></li>
						                            <li> <span>Tgl Booking</span> <span>{{@$invoice->it_tanggal}}</span></li>
						                            <li> <span>Nama</span> <span>{{@$invoice->it_pemesan}}</span></li>
						                            <li> <span>Email</span> <span>{{@$invoice->it_email}}</span></li>
						                            <li> <span>Phone</span> <span>{{@$invoice->it_telp}}</span></li>
						                            <li> <span>Total Tagihan</span> <span>Rp. {!!number_format(@$invoice->it_total_tagihan)!!},-</span></li>
						                            <li> <span>Metode Pembayaran</span> 
						                            	<span>{!!($invoice->it_jenis_pembayaran == 2 ? 'Transfer Bank' : 'Bayar cash di loket')!!}
						                            		<br>
						                            		@php
															    use App\Models\Page;
															    $rekening = Page::select('konten')->where('group','NO_REK')->first();
															    print_r($rekening->konten);
															@endphp
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
						                          			$detail_tiket = $invoice->invoice_tiket_detail;
						                          		@endphp
						                          		@foreach($detail_tiket as $key => $detail)
						                          		<tr>
						                          			<td><small>[{{$detail->booking_group}}]</small> {{$detail->booking_name}}</td>
						                          			<td align="right">{!!number_format($detail->itd_nominal)!!}</td>
						                          			<td align="right">{{$detail->itd_qty}}</td>
						                          			<td align="right">{!!number_format($detail->itd_subtotal)!!}</td>
						                          		</tr>
						                          		@endforeach
						                          	</tbody>
						                          </table>
											</div>
										</div> 
									</div>
									<form>
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Bukti Bayar
												</label>
												<input type="file" name="file_upload" id="file_upload" class="form-control">
											</div>
										</div>
									</form>
				                </div>
				                <div class="row" style="margin-top: 10px;">
									<div class="col-md-12" align="center">
										<button id="btn-proses" class="btn btn-primary">Upload</button>
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

	});
</script>
@endsection