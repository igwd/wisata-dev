@extends('site.template')
@section('navbar')
	@include('site/navbar')
@endsection
@section('content')
	<!-- ini include/tambahin tampilan -->
	@include('site/slider')	
	@include('site/servicebadge')
	<!-- Start about us -->
	@include('site.about')
	<!-- End about us -->
@endsection