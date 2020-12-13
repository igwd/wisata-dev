<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\SlideShow;
use Validator;

class SlideShowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.dashboard.slideshow.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $slider = new SlideShow;
        $msg = array();
        $url_gambar = $request->url_gambar;
        $slider->tema = $request->tema;
        $slider->judul = $request->judul;
        $slider->deskripsi = $request->deskripsi;
        
        // setting up rules
        $rules = array('image' => 'required'); 
        //mimes:jpeg,bmp,png and for max size max:10000
        $file = array('image' => $request->file('image'));
        // doing the validation, passing post data, rules and the messages
        $validator = Validator::make($file, $rules);
        
        if($validator->fails()){
            // send back to the page with the input data and errors
            $msg = array('class'=>'alert-danger','text'=>'Gambar tidak boleh kosong.');
        }else{
            // checking file is valid.
            if ($request->file('image')->isValid()) {
                $destinationPath = 'storage/slideshow'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                $fileName = md5($file).'.'.$extension;
                if (file_exists($destinationPath.'/'.$fileName)) {
                    unlink($destinationPath.'/'.$fileName);
                }

                // uploading file to given path
                if ($request->file('image')->move($destinationPath, $fileName)) {
                    $filePath = $destinationPath.'/'.$fileName;
                    $url_gambar = $filePath;
                }
            }else{
                $msg = array('class'=>'alert-danger','text'=>'Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx');
            }
        }

        //dd($msg);
        $slider->url_gambar = $url_gambar;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            $simpan = $slider->save();
            if($simpan){
                session()->flash('message', array('class'=>'alert-success','text'=>'Berhasil tambah data Slide Show - '.$request->judul));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>'Gagal tambah data Slide Show - '.$request->judul));
            }
        }
        $form = (object) $request->input();
        return view('admin.dashboard.slideshow.create',compact("form"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = slideshow::where("id","=",$id)->first();
        return view('admin.dashboard.slideshow.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = SlideShow::find($id);
        $url_gambar = $request->url_gambar;
        $slider->tema = $request->tema;
        $slider->judul = $request->judul;
        $slider->deskripsi = $request->deskripsi;
        if(!empty($request->file('image'))){
            $file = array('image' => $request->file('image'));
            // setting up rules
            $rules = array('image' => 'required'); 
            //mimes:jpeg,bmp,png and for max size max:10000
            // doing the validation, passing post data, rules and the messages
            $validator = Validator::make($file, $rules);
            if($validator->fails()){
                // send back to the page with the input data and errors
                $msg = array('class'=>'alert-danger','text'=>'Gambar tidak boleh kosong.');
            }else{
                // checking file is valid.
                if ($request->file('image')->isValid()) {
                    $destinationPath = 'storage/slideshow'; // upload path
                    $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                    $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                    $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                    $fileName = md5($file).'.'.$extension;
                    if (file_exists($destinationPath.'/'.$fileName)) {
                        unlink($destinationPath.'/'.$fileName);
                    }

                    // uploading file to given path
                    if ($request->file('image')->move($destinationPath, $fileName)) {
                        $filePath = $destinationPath.'/'.$fileName;
                        $url_gambar = $filePath;
                    }
                }else{
                    $msg = array('class'=>'alert-danger','text'=>'Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx');
                }
            }
        }
        //dd($url_gambar);
        $slider->url_gambar = $url_gambar;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            $simpan = $slider->save();
            if($simpan){
                session()->flash('message', array('class'=>'alert-success','text'=>'Berhasil <i>update</i> data Slide Show - '.$request->judul));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>'Gagal <i>update</i> data Slide Show - '.$request->judul));
            }
        }
        return redirect('admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //$del = SlideShow::where('id',$id)->delete();
        $del = false;
        if($del){
            //@unlink($request->file);
            $msg = array('class'=>'alert-success','text'=>'Berhasil hapus data Slide Show - '.$request->judul);
        }else{
            $msg = array('class'=>'alert-danger','text'=>'Gagal hapus data Slide Show - '.$request->judul);
        }
        return response()->json($msg);
    }

    public function listDataSlideShow(Request $request){
        $data = SlideShow::select([
            'id','tema','judul','deskripsi','url_gambar'
        ]);

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('slideshow', function($query, $keyword) {
                    $sql = "tema like ? OR judul like ? OR deskripsi like ?";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('slideshow', function ($data) {
                $url_edit = url('/')."/admin/slideshow/{$data->id}/edit";
                $url_delete = url('/')."/admin/slideshow/{$data->id}/destroy";
                $url_gambar = "";
                if(!empty($data->url_gambar)){
                    $url_gambar = url('/')."/{$data->url_gambar}";
                }else{
                    $url_gambar = url('/')."/public/site/assets/img/slider/1.jpg";
                }
                $html = "<section id='mu-slider'>
                            <div class='mu-slider-single'>
                                <div class='mu-slider-img'>
                                    <figure>
                                        <img src='{$url_gambar}' alt='{$data->judul}'>
                                    </figure>
                                </div>
                            <div class='mu-slider-content'>
                                <h4>{$data->tema}</h4>
                                <span></span>
                                <h2>{$data->judul}</h2>
                                <p>{$data->deskripsi}</p>
                                <div class='slider-action'>  
                                    <a href='{$url_edit}' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>
                                    <a onclick='deleteSlideShow()' class='btn btn-sm btn-danger btn-delete' data-id='{$data->id}' data-judul='{$data->judul}' data-file='{$data->url_gambar}'><i class='fa fa-trash'></i></a>
                                </div>
                            </div>
                        </div>
                    </section>";
                return $html;
            })->rawColumns(['slideshow'])
            ->make(true);
    }
}
