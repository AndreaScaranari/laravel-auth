@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <header>
        <h1 class="text-center pb-3">Posts</h1>
    </header>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
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
