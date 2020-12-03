<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Models\Page;

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
        $data = array();
        $page = Page::all()->toArray();
        foreach ($page as $key => $value) {
            $data[$value['app_key']][] = $value;
        }
        //dd($data);
        return view('site.homepage')->with($data);
    }
}
