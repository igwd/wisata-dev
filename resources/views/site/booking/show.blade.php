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

	});
</script>
@endsection