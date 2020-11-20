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

	<!-- Start about us counter -->
	@include('site.aboutbadge')
	<!-- End about us counter -->

	<!-- Start features section -->
	@include('site.featurebadge')
	<!-- End features section -->

	<!-- Start latest course section -->
	@include('site.coursebadge')
	<!-- End latest course section -->

	<!-- Start our teams -->
	@include('site.teamsbadge')
	<!-- End our teams -->

	<!-- Start testimonial -->
	@include('site.testimonialbadge')
	<!-- End testimonial -->

	<!-- Start from blog -->
	@include('site.blogbadge')
	<!-- End from blog -->
@endsection