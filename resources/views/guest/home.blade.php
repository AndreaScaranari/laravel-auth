@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <header>
        <h1>Boolpress</h1>
        <h3>Scopri i nostri post</h3>
    </header>

    @if ($posts->hasPages())
        {{ $posts->links() }}
    @endif
    @forelse ($posts as $post)
        <div class="card my-5">
            <div class="card-header">
                {{ $post->title }}
            </div>
            <div class="card-body">
                <div class="row">
                    @if ($post->image)
                        <div class="col-3">
                            <img src="{{ $post->image }}" alt="{{ $post->title }}">
                        </div>
                    @endif
                </div>

                <div class="col">
                    <h5 class="card-title mb-3">{{ $post->title }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's content.</p>
                </div>

                {{-- <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a> --}}
            </div>
        </div>
    @empty
        <h3 class="text-center">Non ci sono post da mostrare</h3>
    @endforelse
@endsection
