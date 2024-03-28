@extends('layouts.app')
{{-- @dd($post->printImage()) --}}
@section('title', 'Posts')

@section('content')
    <header>
        <h1 class="text-center pb-3">{{ $post->title }}</h1>
    </header>

    <div class="clearfix">
        @if ($post->image)
            <img src="{{ $post->printImage() }}" alt="{{ $post->title }}" class="me-2 float-start">
        @endif
        <p>{{ $post->content }}</p>
        <div>
            <strong>Creato il:</strong> {{ $post->getFormattedDate('created_at', 'd-m-Y H:i:s') }}
            <strong>Ultima modifica il:</strong> {{ $post->getFormattedDate('updated_at', 'd-m-Y H:i:s') }}
        </div>
    </div>

    <footer class="d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Torna indietro
        </a>
        <div class="d-flex justify-content-between gap-2">
            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-pencil me-2"></i>
                Modifica
            </a>
            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="delete-form">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash me-2" data-bs-toggle="modal" data-bs-target="#modal"></i>
                    Elimina
                </button>
            </form>
        </div>
    </footer>
@endsection

@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
