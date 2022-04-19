@extends('app')

@section('title', '404')
@section('description', 'Page Not Found')
@section('image', 'views/src/dist/images/social-image.png')
@section('image_width', '1012')
@section('image_height', '506')
@section('canonical', '404')

@section('content')
<section>
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1 class="display-1">404</h1>
                <h2>Ooops, something went wrong...</h2>
                <a href="/" class="btn btn-primary mt-5 mb-6">Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection