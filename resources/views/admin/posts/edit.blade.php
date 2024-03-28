@extends('layouts.app')

@section('title', 'Modifica Post')

@section('content')
    <header>
        <h1>Nuovo Post</h1>
    </header>

    @include('includes.posts.form')

@endsection

@section('scripts')
    @vite('resources/js/image_preview.js')
@endsection
