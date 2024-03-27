<?php

namespace App\Http\Controllers\Admin;


use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $filter = $request->query('filter');
        $query = Post::orderByDesc('updated_at')->orderByDesc('created_at');

        if($filter){
            $value = $filter === 'published';
            $query->whereIsPublished($value);
        }

        $posts = $query->paginate(10)->withQueryString();
        return view('admin.posts.index', compact('posts', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = new Post();
        return view('admin.posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|min:1|max:30|unique:posts',
            'content' => 'required|string',
            'image' => 'nullable|image',
            'is_published' => 'nullable|boolean',
        ],
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.min' => 'Il titolo deve essere composto da almeno :min caratteri',
            'title.max' => 'Il titolo deve essere composto al massimo da :max caratteri',
            'title.unique' => 'Non possono esserci due post con lo stesso titolo',
            'content.required' => 'Il contenuto è obbligatorio',
            'image.image' => 'Il file inserito non è un\'immagine',
            'is_published.boolean' => 'Il valore del campo di pubblicazione non è valido',

        ]);

        $data = $request->all();

        $post = new Post();

        $post->fill($data);
        $post->slug = Str::slug($post->title);
        $post->is_published = Arr::exists($data, 'is_published');

        if(Arr::exists($data, 'image')){
            $img_url = Storage::putFile('post_images', $data['image']);
            $post->image = $img_url;
        }

        $post->save();

        return to_route('admin.posts.show', $post)->with('message','Post creato con successo')->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:30', Rule::unique('posts')->ignore($post->id)],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'is_published' => ['nullable', 'boolean'],
        ],
        [
            'title.required' => 'Il titolo è obbligatorio',
            'title.min' => 'Il titolo deve essere composto da almeno :min caratteri',
            'title.max' => 'Il titolo deve essere composto al massimo da :max caratteri',
            'title.unique' => 'Non possono esserci due post con lo stesso titolo',
            'content.required' => 'Il contenuto è obbligatorio',
            'image.image' => 'Il file inserito non è un\'immagine',
            'is_published.boolean' => 'Il valore del campo di pubblicazione non è valido',
            
        ]);

        $data = $request->all();

        $data['slug'] = Str::slug($data['title']);
        $data['is_published'] = Arr::exists($data, 'is_published');

        if(Arr::exists($data, 'image')){

            if($post->image) Storage::delete($post->image);

            $img_url = Storage::putFile('post_images', $data['image']);
            $post->image = $img_url;
        }

        $post->update($data);

        return to_route('admin.posts.show', $post)->with('message','Post modificato con successo')->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('admin.posts.index')
            ->with('toast-button-type', 'danger')
            ->with('toast-message', 'Post eliminato')
            ->with('toast-label', config('app.name'))
            ->with('toast-method', 'PATCH')
            ->with('toast-route', route('admin.posts.restore', $post->id))
            ->with('toast-button-label', 'Annulla');
    }
    
    // * Rotte Soft Delete
    
    public function trash(){
        $posts = Post::onlyTrashed()->get();
        return view('admin.posts.trash', compact('posts'));
    }
    
    public function restore(Post $post){
        $post->restore();
        return to_route('admin.posts.index')->with('type', 'success')->with('message', 'Post ripristinato con successo');
    }
    
    public function drop(Post $post){

        if($post->image) Storage::delete($post->image);
        $post->forceDelete();
        
        return to_route('admin.posts.trash')->with('type', 'warning')->with('message', 'Post eliminato definitivamente con successo');
    }
}