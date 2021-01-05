<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;



class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
             ->only(['create','store','update','destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(BlogPost::all());
        // DB::connection()->enableQueryLog();

        // // $posts = BlogPost::all();
        // $posts = BlogPost::with('comments')->get();


        // foreach ($posts as $post){
        //     foreach ($post->comments as $comment){
        //         echo $comment->content;
        //     }
        // }

        // dd(DB::getQueryLog());

        return view(
            'posts.index',
            ['posts'=>BlogPost::latest()->withCount('comments')->get(),
            'mostCommented'=> BlogPost::mostCommented()->take(5)->get(),
            'mostActive' =>User::withMostBlogPosts()->take(5)->get(),
            'mostActiveLastMonth' =>User::withMostBlogPostsLastMonth()->take(5)->get(),
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(BlogPost::find($id));
        // $request->session()->reflash();
        return view('posts.show', ['posts'=>BlogPost::with(['comments' => function ($query) {
            return $query->latest();
        }])->findOrFail($id)]);
    }

    public function create()
    {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        // dd($request->all());
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $blogPost = BlogPost::create($validatedData);
        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show',['post'=> $blogPost->id]);
    }
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog-post");
        // }

        return view('posts.edit', ['posts'=>$post]);
    }
    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);
        // if (Gate::denies('update-post', $post)) {
        //     abort(403, "You can't edit this blog-post");
        // }

        $validatedData = $request->validated();
        // $posts->title=$validatedData['title'];
        // $posts->content=$validatedData['content'];
        $post->fill($validatedData);
        $post->save();
        $request->session()->flash('status', 'Blog post was updated!');
        return redirect()->route('posts.show', ['post'=>$post->id]);

    }
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);

        // $this->authorize($post); // jos bolje i jednostavanije
        $this->authorize('delete', $post);
        // $this->authorize('posts.delete', $post); //ovo gore lakse generisati policy klase
        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, "You can't delete this blog-post");
        // }

        $post->delete();

        session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }

}
