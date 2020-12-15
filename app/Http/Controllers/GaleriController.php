<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use DB;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function photo(Request $request)
    {
        $q = $request->search;
        $data = Galeri::where('group_kategori','=',DB::raw('"PHOTO"'))
                ->where(function($query) use ($q){
                    $query->where('judul', 'LIKE', '%' . $q . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $q . '%');
                })->paginate(6);
        $data->appends(['search' => $q]);
        return view('site.galeri-photo',compact('data'));
        /*$data = Fasilitas::paginate(6);
        return view('admin.galeri.photo.index',compact('data'));*/
    }

    public function video(Request $request)
    {
        $q = $request->search;
        $data = Galeri::where('group_kategori','=',DB::raw('"VIDEO"'))
                ->where(function($query) use ($q){
                    $query->where('judul', 'LIKE', '%' . $q . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $q . '%');
                })->paginate(4);
        $data->appends(['search' => $q]);
        return view('site.galeri-video',compact('data'));
        /*$data = Fasilitas::paginate(6);
        return view('admin.galeri.photo.index',compact('data'));*/
    }
}
