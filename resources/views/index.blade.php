@extends('layouts.main')

@section('title', 'Home Page')

@section('content')
    <div class="card card-profile mt--300" style="background: none;border: none">

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="col-lg-8 m-lg-auto">
            <div id="posts">
                @include('_load_more_posts', ['items' => $posts])
            </div>
        </div>
    </div>
@endsection