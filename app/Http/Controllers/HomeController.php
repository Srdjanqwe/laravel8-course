<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function home()
    {
        return view('home');
    }
    public function contact()
    {
        return view('contact');
    }
    public function blogPost($id, $welcome =1)
    {
        $pages = [
            1=>[
                'title'=>'from 1',

            ],
            2=>[
                'title'=>'from 2',

            ],
        ];
        $welcomes = [1 => '<b>Hello</b> ', 2=>'Welcome to '];

        return view('blog-post', [
            'data'=>$pages[$id],
            'welcome'=>$welcomes[$welcome],
            ]);
    }
}
