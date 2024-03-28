@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <header class="d-flex align-items-center justify-content-between flex-column">
        <h1 class="m-0">Posts</h1>
        <div class="d-flex justify-content-between w-100 p-3">
            <a href="{{ route('admin.posts.create') }}" class="btn btn-success d-block">
                <i class="fas fa-plus me-2"></i>Nuovo</a>
            <form action="{{ route('admin.posts.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="filter">
                        <option value="">Tutti</option>
                        <option value="published" @if ($filter === 'published') selected @endif>Pubblicati</option>
                        <option value="drafts" @if ($filter === 'drafts') selected @endif>Bozze</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Filtra</button>
                </div>
            </form>
            <a href="{{ route('admin.posts.trash') }}" class="btn btn-secondary d-block">
                <i class="fas fa-trash-arrow-up me-2"></i>Guarda Cestino</a>
        </div>

    </header>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Stato Pubblicazione</th>
                <th scope="col">Creato il</th>
                <th scope="col">Ultima modifica</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($posts as $post)
                <tr>
                    <th scope="row">{{ $post->id }}</th>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->is_published ? 'Pubblicato' : 'Bozza' }}</td>
                    <td>{{ $post->getFormattedDate('created_at') }}</td>
                    <td>{{ $post->getFormattedDate('updated_at') }}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modal">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <h3 class="text-center">Non ci sono post da mostrare!</h3>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    @if ($posts->hasPages())
        {{ $posts->links() }}
    @endif

@endsection


@section('scripts')
    @vite('resources/js/delete_confirmation.js')
@endsection
