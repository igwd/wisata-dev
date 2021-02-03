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
						<div class="col-md-9">
							<div class="mu-course-container mu-course-details">
				                <div class="row">
				                  <div class="col-md-12">
				                    <div class="mu-latest-course-single">
				                      <div class="mu-latest-course-single-content">
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
						                        		<li>
						                        			{{$value->mt_nama_tiket}} <small>({{$value->mt_keterangan}})</small> : <i>Rp. {!!number_format($value->mt_harga)!!}</i>
						                        		</li>
													@endforeach
						                        		</ul>	 
													</p>
											</div>
					                     </div>
					                    <form role="form" id="form-data" name="form-data">
					                      	<input type="hidden" name="_method" value="POST">
											@csrf
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
							                              <td> 
							                              	{{$value->mt_nama_tiket}}
							                              	<input type="hidden" name="mt_nama_tiket[{{$value->mt_id}}]" id="mt_nama_tiket{{$value->mt_id}}" class="form-control" value="{{$value->mt_nama_tiket}}">
							                              </td>
							                              <td align="right"> 
							                              	{!!number_format($value->mt_harga)!!} 
							                              	<input type="hidden" name="harga[{{$value->mt_id}}]" id="harga{{$value->mt_id}}" class="form-control" value="{{$value->mt_harga}}">
							                              </td>
							                              <td>
							                              	<input type="number" name="qty[{{$value->mt_id}}]" id="qty{{$value->mt_id}}" data-tiketid="{{$value->mt_id}}" data-harga="{{$value->mt_harga}}" class="qty form-control" value="{{@$data->qty[$value->mt_id]}}">
							                              </td>
							                              <td align="right">
							                              	<input type="text" style="text-align:right;" readonly name="subtotal[{{$value->mt_id}}]" id="subtotal{{$value->mt_id}}" class="subtotal form-control" value="0">
							                              </td>
							                            </tr>
							                            @endforeach
							                          </tbody>
							                          <tfoot>
							                          	<td colspan="3">
							                          		Total
							                          	</td>
							                          	<td align="right">
							                          		<input readonly type="text" style="text-align: right;" value="0" name="total" class="form-control" id="total">
							                          	</td>
							                          </tfoot>
						                        	</table>
						                        </div>
						                      </div>
			            	            </form>
					                      <div class="row" style="margin-top: 10px;">
					                      	<div class="col-md-12" align="center">
					                      		<button id="btn-proses" class="btn btn-success"><i class="fa fa-check"></i> Pesan Tiket</button>
					                      	</div>
					                      </div>
				                      </div>
				                    </div> 
				                  </div>                                   
				                </div>
				            </div>
						</div>
						<div class="col-md-3">
			                <!-- start sidebar -->
			                <aside class="mu-sidebar">
			                  <!-- start single sidebar -->
			                  <div class="mu-single-sidebar">
			                    <h4>Kuliner Populer</h4>
			                    <div id="popular-kuliner" class="mu-sidebar-popular-courses">
			                    	
			                    </div>
			                  </div>
			                </aside>
			                <!-- start sidebar -->
			                <aside class="mu-sidebar">
			                  <!-- start single sidebar -->
			                  <div class="mu-single-sidebar">
			                    <h4>Penginapan Populer</h4>
			                    <div id="popular-homestay" class="mu-sidebar-popular-courses">
			                    	
			                    </div>
			                  </div>
			                </aside>
			                <!-- start sidebar -->
			                <aside class="mu-sidebar">
			                  <!-- start single sidebar -->
			                  <div class="mu-single-sidebar">
			                    <h4>Transport Populer</h4>
			                    <div id="popular-transport" class="mu-sidebar-popular-courses">
			                    	
			                    </div>
			                  </div>
			                </aside>
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

		$('#btn-proses').click(function(){
			var data = $("#form-data").serialize();
			$.ajax({
				url:"{{url('/')}}/booking/addtikettocart",
				data:data,
				type:"POST",
				dataType:"JSON",
				success:function(data){
					if(data.success==1){
	          toast_success('Berhasil',data.msg);
	        }else if(data.success == 2){
	          toast_warning('Informasi',data.msg);
	        }else{
	        	toast_error('Gagal',data.msg);
	        }
	        getCartItem();
					//console.log(data);
				},error:function(error){
					console.log(error.XMLHttpRequest);
				}
			});
		});

		//most popular kuliner
		$.ajax({
      url:"{{url('/')}}/fasilitas/kuliner/popular",
      type:"GET",
      dataType:"JSON",
      success:function(data){
        $('#popular-kuliner').html(data);
      },error:function(error){
        console.log(error.XMLHttpRequest);
        $('#popular').html("Not Found");
      }
    });

    //most popular homestay
		$.ajax({
      url:"{{url('/')}}/fasilitas/penginapan/popular",
      type:"GET",
      dataType:"JSON",
      success:function(data){
        $('#popular-homestay').html(data);
      },error:function(error){
        console.log(error.XMLHttpRequest);
        $('#popular').html("Not Found");
      }
    });

    //most popular transport
		$.ajax({
      url:"{{url('/')}}/fasilitas/transportasi/popular",
      type:"GET",
      dataType:"JSON",
      success:function(data){
        $('#popular-transport').html(data);
      },error:function(error){
        console.log(error.XMLHttpRequest);
        $('#popular').html("Not Found");
      }
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