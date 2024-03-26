@if ($post->exists)
    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" novalidate>
        @method('PUT')
    @else
        <form action="{{ route('admin.posts.store') }}" method="POST" novalidate>
@endif

@csrf
<div class="row">
    <div class="col-12">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Titolo..."
                value="{{ old('title', $post->title) }}" required>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">Contenuto del Post</label>
            <textarea class="form-control" name="content" id="content" rows="12" required>
                        {{ old('content', $post->content) }}
                    </textarea>
        </div>
    </div>
    <div class="col-11">
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="url" class="form-control" name="image" id="image" placeholder="http:// o https://"
                value="{{ old('image', $post->image) }}">
        </div>
    </div>
    <div class="col-1">
        <div class="mb-3">
            <img src="{{ old('image', $post->image ?? 'https://marcolanci.it/boolean/assets/placeholder.png') }}"
                class="img-fluid" alt="Immagine del post" id="preview" name="preview">
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="is_published" name="is_published"
                @if (old('is_published', $post->is_published)) checked @endif>
            <label class="form-check-label" for="is_published">
                Pubblicato
            </label>
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
