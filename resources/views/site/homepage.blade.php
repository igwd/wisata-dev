@extends('site.template')
@section('navbar')
	@include('site/navbar')
@endsection
@section('content')
	@include('site/slider')	
	@include('site/servicebadge')
	<!-- Start about us -->
	@include('site.about')
	<!-- End about us -->

	<!-- Start latest course section -->
	@include('site.coursebadge')
	<!-- End latest course section -->

	<!-- Start from blog -->
	@include('site.blogbadge')
	<!-- End from blog -->
@endsection