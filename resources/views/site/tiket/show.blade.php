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
		           <h2>Pemesanan Tiket</h2>
		           <ol class="breadcrumb">
		            <li>Tiket</li>
		            <li class="active">Verifikasi</li>            
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
                    <li>{!!($invoice->status_tiket_id >= 1 ? '<i class="fa fa-check-circle"></i>' : '<i class="fa fa-book"></i>')!!} Lengkapi Form Isian Data</li>
                    <li><i class="fa fa-envelope"></i> Verifikasi Tiket Melalui E-mail</li>
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
							
								<div class="mu-course-container mu-course-details">
	                <div class="row">
	                  <div class="col-md-12">
	                    <div class="mu-latest-course-single">
	                      <div class="mu-latest-course-single-content">
	                        <h4>Data Diri</h4>
	                        <div class="row">
	                          <div class="col-md-4">
	                          	<div class="form-group">
	                          		<label>Nama</label>
	                          		<input type="text" name="nama" id="nama" readonly class="form-control" value="{{$invoice->it_pemesan}}">
	                          	</div>
	                          </div>
	                          <div class="col-md-4">
	                          	<div class="form-group">
	                          		<label>Email</label>
	                          		<input type="email" name="email" id="email" readonly class="form-control" value="{{$invoice->it_email}}">
	                          	</div>
	                          </div>
	                          <div class="col-md-4">
	                          	<div class="form-group">
	                          		<label>Phone</label>
	                          		<input type="text" name="telp" id="telp" readonly="" class="form-control" value="{{$invoice->it_telp}}">
	                          	</div>
	                          </div>
	                        </div>
	                        <h4>Data Tiket</h4>
	                        <div class="row">
		                        <div class="col-md-8">
														</div>
		                      	<div class="col-md-4">
		                      		<div class="form-group">
		                        		<label>Tanggal Booking</label>
												        <input type="text" readonly class="form-control" id="tanggal" value="{{$invoice->it_tanggal}}">
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
		                            </tr>
		                          </thead>
		                          <tbody>
		                          	@foreach($invoice->invoice_tiket_detail as $tiket => $value)
		                            <tr>
		                              <td>{{$value->tiket->mt_nama_tiket}}</td>
		                              <td align="right"> {!!number_format($value->itd_nominal)!!} </td>
		                              <td><input type="number" name="qty" readonly class="qty form-control" value="{{$value->itd_qty}}"></td>
		                              <td align="right"><input type="text" style="text-align:right;" readonly name="subtotal" class="subtotal form-control" value="{{$value->itd_subtotal}}"></td>
		                            </tr>
		                            @endforeach
		                          </tbody>
		                          <tfoot>
		                          	<td colspan="3">Total</td>
		                          	<td align="right"><input readonly type="text" style="text-align: right;" value="{{$invoice->it_total_tagihan}}" name="total" class="form-control" id="total"></td>
		                          </tfoot>
		                        </table>
		                        </div>
		                      </div>
		                      <h4>Metode Pembayaran</h4>
		                      <div class="row">
		                      	<div class="col-md-6">
		                      		<div class="form-check">
															  <input class="form-check-input" type="radio" name="metode_bayar" id="metode_bayar_1" value="1">
															  <label class="form-check-label" for="metode_bayar_1">
															    Bayar cash di loket
															  </label>
															</div>
		                      	</div>
		                      	<div class="col-md-6">
		                      		<div class="form-check">
															  <input class="form-check-input" type="radio" name="metode_bayar" id="metode_bayar_2" value="2" checked>
															  <label class="form-check-label" for="metode_bayar_2">
															    Transfer Bank
															  </label>
															</div>
															<p>
																@php
															    use App\Models\Page;
															    $rekening = Page::select('konten')->where('group','NO_REK')->first();
															  @endphp
															  {!!$rekening->konten!!}
															</p>
		                      	</div>
		                      </div>
		                      <div class="row" style="margin-top: 10px;">
		                      	<div class="col-md-12" align="center">
		                      		<button id="btn-proses" class="btn btn-primary"><i class="fa fa-check"></i> Pesan Tiket</button>
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
				console.log($(this).val());
				total += parseFloat(plainNumber($(this).val()));
			});
			var value = total,
			plain = plainNumber(value),
			reversed = reverseNumber(plain),
			reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
			normal = reverseNumber(reversedWithDots);
			$('#total').html(normal);
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
</script>
@endsection