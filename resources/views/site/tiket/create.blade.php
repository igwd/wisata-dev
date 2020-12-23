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
		            <li><a href="#">Home</a></li>            
		            <li class="active">Tiket</li>
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
                    <li><i class="fa fa-book"></i> Lengkapi Form Isian Data</li>
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
							<form role="form" id="form-data" name="form-data" method="POST" action="{{url('/')}}/tiket/pesan">
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
						          @php
						          	//print_r($data);
						          @endphp
	                    <div class="mu-latest-course-single">
	                      <div class="mu-latest-course-single-content">
	                        <h4>Data Diri</h4>
	                        <div class="row">
	                          <div class="col-md-4">
	                          	<div class="form-group">
	                          		<label>Nama</label>
	                          		<input type="text" name="nama" id="nama" class="form-control" required="" value="{{@$data->nama}}">
	                          	</div>
	                          </div>
	                          <div class="col-md-4">
	                          	<div class="form-group">
	                          		<label>Email</label>
	                          		<input type="email" name="email" id="email" class="form-control" required="" value="{{@$data->email}}">
	                          	</div>
	                          </div>
	                          <div class="col-md-4">
	                          	<div class="form-group">
	                          		<label>Phone</label>
	                          		<input type="text" name="telp" id="telp" class="form-control" required="" value="{{@$data->telp}}">
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
		                        		<label>Tanggal Booking</label>
												        <input type="text" readonly class="datepicker form-control" id="tanggal" name="tanggal" value="{!!(!empty($data->tanggal) ? @$data->tanggal : date('Y-m-d')) !!}">
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
		                          	@foreach(Tiket::all() as $tiket => $value)
		                            <tr>
		                              <td> {{$value->mt_nama_tiket}}</td>
		                              <td align="right"> 
		                              	{!!number_format($value->mt_harga)!!} 
		                              	<input type="hidden" name="harga[{{$value->mt_id}}]" id="harga{{$value->mt_id}}" class="form-control" value="{{$value->mt_harga}}">
		                              </td>
		                              <td><input type="number" name="qty[{{$value->mt_id}}]" id="qty{{$value->mt_id}}" data-tiketid="{{$value->mt_id}}" data-harga="{{$value->mt_harga}}" class="qty form-control" value="{{@$data->qty[$value->mt_id]}}"></td>
		                              <td align="right"><input type="text" style="text-align:right;" readonly name="subtotal[{{$value->mt_id}}]" id="subtotal{{$value->mt_id}}" class="subtotal form-control" value="0"></td>
		                            </tr>
		                            @endforeach
		                          </tbody>
		                          <tfoot>
		                          	<td colspan="3">Total</td>
		                          	<td align="right"><input readonly type="text" style="text-align: right;" value="0" name="total" class="form-control" id="total"></td>
		                          </tfoot>
		                        </table>
		                        </div>
		                      </div>
		                      <h4>Metode Pembayaran</h4>
		                      <div class="row">
		                      	<div class="col-md-6">
		                      		<div class="form-check">
															  <input class="form-check-input" type="radio" name="metode_bayar" id="metode_bayar_1" value="1" {!!(($data->metode_bayar == 1) ? 'checked' : '')!!}>
															  <label class="form-check-label" for="metode_bayar_1">
															    Bayar cash di loket
															  </label>
															</div>
		                      	</div>
		                      	<div class="col-md-6">
		                      		<div class="form-check">
															  <input class="form-check-input" type="radio" name="metode_bayar" id="metode_bayar_2" value="2" {!!(($data->metode_bayar == 2) ? 'checked' : '')!!}>
															  <label class="form-check-label" for="metode_bayar_2">
															    Transfer Bank
															  </label>
															</div>
															<p>
																@php
															    /*use App\Models\Page;
															    $rekening = Page::select('konten')->where('group','NO_REK')->first();
															    print_r($rekening->konten);*/
															  @endphp
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
</script>
@endsection