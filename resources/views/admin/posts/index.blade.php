@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <header class="d-flex align-items-center justify-content-between">
        <h1>Posts</h1>
        <form action="{{ route('admin.posts.index') }}" method="GET">
            <div class="input-group">
                <select class="form-select" name="filter">
                    <option value="">Tutti</option>
                    <option value="published" @if ($filter === 'published') selected @endif>Pubblicati</option>
                    <option value="drafts" @if ($filter === 'drafts') selected @endif>Bozze</option>
                </select>
                <button class="btn btn-outline-secondary" type="submit">Button</button>
            </div>
        </form>
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
                    <td>{{ $post->created_at }}</td>
                    <td>{{ $post->updated_at }}</td>
                    <td>
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('admin.posts.show', $post) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-pencil"></i>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
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
