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

    public function secret()
    {
        return view('secret');
    }
}
