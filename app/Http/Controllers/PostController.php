<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\DB;



class PostController extends Controller
{
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
            ['posts'=>BlogPost::withCount('comments')->get()]);
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
        return view('posts.show', ['posts'=>BlogPost::with('comments')->findOrFail($id)]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        // dd($request->all());
        $validatedData = $request->validated();


        $blogPost = BlogPost::create($validatedData);
        $request->session()->flash('status', 'Blog post was created!');

        return redirect()->route('posts.show',['post'=> $blogPost->id]);
    }
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);
        return view('posts.edit', ['posts'=>$post]);
    }
    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id);
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
        $post->delete();

        session()->flash('status', 'Blog post was deleted!');
        return redirect()->route('posts.index');
    }

}
