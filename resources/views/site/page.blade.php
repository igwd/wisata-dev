@extends('site.template')
@section('navbar')
	@include('site/navbar')
@endsection
@section('content')
<section id="mu-page-breadcrumb">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="mu-page-breadcrumb-area">
           <h2>{{$data->judul}}</h2>
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
	      		{!!$data->konten!!}      
	        </div>
	    </div>
	</div>
</div>
</section>    
@endsection