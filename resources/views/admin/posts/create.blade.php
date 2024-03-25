@extends('layouts.app')

@section('title', 'Crea Post')

@section('content')
    <header>
        <h1>Nuovo Post</h1>
    </header>

    <form action="{{ route('admin.posts.store') }}" method="POST" novalidate>
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="mb-3">
                    <label for="title" class="form-label">Titolo</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Titolo..."
                        value="{{ old('title', '') }}" required>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3">
                    <label for="content" class="form-label">Contenuto del Post</label>
                    <textarea class="form-control" name="content" id="content" rows="12" required>
                        {{ old('content', '') }}
                    </textarea>
                </div>
            </div>
            <div class="col-11">
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="url" class="form-control" name="image" id="image"
                        placeholder="http:// o https://" value="{{ old('image', '') }}">
                </div>
            </div>
            <div class="col-1">
                <div class="mb-3">
                    <img src="https://marcolanci.it/boolean/assets/placeholder.png" class="img-fluid"
                        alt="Immagine del post" id="preview" name="preview" value="{{ old('preview', '') }}">
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Torna alla lista</a>

            <div class="d-flex align-items-center gap-2">
                <button type="reset" class="btn btn-warning"><i class="fas fa-eraser me-2"></i> Svuota i
                    campi</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-floppy-disk me-2"></i>Salva</button>
            </div>
        </div>
    </form>
@endsection
