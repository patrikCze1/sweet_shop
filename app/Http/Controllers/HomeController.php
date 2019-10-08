<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function contact()
    {
        return view('kontakt');
    }

    public function products()
    {
        return view('sortiment');
    }

    public function administration()
    {
        return view('admin.index');
    }

    public function cookie()
    {
        session()->put('cookie', 'ok');
        return redirect()->back();
    }
}
