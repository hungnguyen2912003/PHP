@extends('user.layouts.master')

@section('title', 'Home')

@section('content')
<!-- Tranding news carousel-->
@include('user.home.tranding-new-carousel')
<!-- End Tranding news carousel -->

<!-- Popular news -->
@include('user.home.popular-news')
<!-- End Popular news -->

<div class="large_add_banner">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="large_add_banner_img">
                    <img src="{{ asset('user/images/placeholder_large.jpg') }}" alt="adds">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Popular news category -->
@include('user.home.popular-news-category')
<!-- End Popular news category -->
@endsection