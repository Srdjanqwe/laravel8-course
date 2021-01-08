<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Cache;
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
            [
                'posts'=>BlogPost::latest()->withCount('comments')->with('user')->with('tags')->get(),

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
        $blogPost = Cache::tags(['blog-post'])->remember('blog-post-{$id}', 60, function () use($id) {
            return BlogPost::with('comments')->with('tags')->with('user')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey="blog-post-{$id}-counter";
        $usersKey="blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey,[]);
        $usersUpdate = [];
        $differences = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >=1) {
                $differences--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(!array_key_exists($sessionId, $users) || $now->diffInMinutes($users[$sessionId]) >=1) {
            $differences++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);

        if(!Cache::tags(['blog-post'])->has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $differences);
        }

        $counter =Cache::tags(['blog-post'])->get($counterKey);

        // dd(BlogPost::find($id));
        // $request->session()->reflash();
        return view('posts.show',
        ['posts' => $blogPost,
            'counter' => $counter,
        ]);
        // ['posts'=>BlogPost::with(['comments' => function ($query) {
            // return $query->latest();
        // }])->findOrFail($id)]);
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

        return view('posts.edit', ['posts'=> $post]);
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
