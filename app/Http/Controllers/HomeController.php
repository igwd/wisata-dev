<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\Roles;

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
    public function index(Request $request)
    {
        /*echo "<pre>";
        print_r($request->session()->all());
        echo "</pre>";*/
        /*foreach ($user->user_roles as $role) {
            echo $role->role_name;
        }*/
        return view('site.homepage');
    }
}
