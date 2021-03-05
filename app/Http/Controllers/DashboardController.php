<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
Use App\Blog;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
     if (auth()->user()->id==1) {
         $blogs=Blog::all();
         return view('admin')->with('blogs',$blogs);
     } else {
         # code...
     }
     

        $user_id= auth()->user()->id;
       $user=User::find($user_id);
        return view('dashboard')->with('blogs',$user->blogs);
    }
}
