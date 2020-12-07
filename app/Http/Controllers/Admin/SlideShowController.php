<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Models\SlideShow;

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
        return view('slideshow.create');
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
        $slider = new slideshow;

        $slider->judul = $request->judul;
        $slider->deskripsi = $request->deskripsi;
        $slider->status_id = 1;

        $ins = $slider->save();

        if($ins){
            if(!empty($request->file('image'))){
                $file = array('image' => $request->file('image'));
                //print_r($file);
                // setting up rules
                $rules = array('image' => 'required'); 
                //mimes:jpeg,bmp,png and for max size max:10000
                // doing the validation, passing post data, rules and the messages
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    // send back to the page with the input data and errors
                    //return Redirect::to('daftar/uploadfoto?gagal=1')->withInput()->withErrors($validator);
                    return "Gagal";
                } else {
                    // checking file is valid.
                    if ($request->file('image')->isValid()) {
                        $destinationPath = 'protected/storage/slideshow'; // upload path
                        $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                        $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                        $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                        $fileName = $file.'.'.$extension;
                        if (file_exists($destinationPath.'/'.$fileName)) {
                        unlink($destinationPath.'/'.$fileName);
                    }
                    // renameing image
                    //$request->file('image')->move($destinationPath, $fileName); // uploading file to given path
                  
                        if ($request->file('image')->move($destinationPath, $fileName)) {
                                $filePath = $destinationPath.'/'.$fileName;
                                $id = $slider->id;
                                //menyimpan nama file di database
                                $save = slideshow::where('id','=',$id)
                                ->update(
                                    array(
                                            'image' => $filePath
                                            //'flag_step_counter'=>'2',
                                        )
                                );
                            // sending back with message
                            /*Session::flash('message', 'Upload successfully');
                            return redirect('/listSlider');*/
                            //return Redirect::to('daftar/uploadfoto?sukses=1');
                        }
                    } else {
                      session()->flash('error', 'Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx');
                    }
                }
                session()->flash('success', 'Berhasil Menyimpan Slide Show');
            }else{
                session()->flash('success', 'Berhasil Menyimpan Slide Show');
            }
        }else{
            session()->flash('error', 'Gagal Menyimpan Slide Show');
        }
        return redirect('admin/slideshow/list');
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
        $data = slideshow::where("id","=",$id)->first();
        return view('slideshow.show',compact('data'));
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
        return view('admin.slideshow.edit',compact('data'));
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
        $url_gambar = "";
        dd($slider);

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
                //return Redirect::to('daftar/uploadfoto?gagal=1')->withInput()->withErrors($validator);
                session()->flash('message', array('class'=>'alert-danger','txt'=>'Gambar tidak boleh kosong.'));
            }else{
                // checking file is valid.
                if ($request->file('image')->isValid()) {
                    $destinationPath = 'storage/slideshow'; // upload path
                    $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                    $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                    $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                    $fileName = $file.'.'.$extension;
                    if (file_exists($destinationPath.'/'.$fileName)) {
                        unlink($destinationPath.'/'.$fileName);
                    }
                    // renameing image
                    //$request->file('image')->move($destinationPath, $fileName); // uploading file to given path
                  
                    if ($request->file('image')->move($destinationPath, $fileName)) {
                            $filePath = $destinationPath.'/'.$fileName;
                            $url_gambar = $filePath;
                        // sending back with message
                        /*Session::flash('message', 'Upload successfully');
                        return redirect('/listSlider');*/
                        //return Redirect::to('daftar/uploadfoto?sukses=1');
                    }
                }else{
                    session()->flash('message', array('class'=>'alert-danger','txt'=>'Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx'));
                }
            }
            session()->flash('success', 'Berhasil Menyimpan Slide Show');
        }else{
            session()->flash('success', 'Berhasil Menyimpan Slide Show');
        }
        return redirect('admin/slideshow/list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $del = slideshow::where('id',$id)->delete();
        if($del){
            $arr = array("submit"=>1);
        }else{
            $arr = array("submit"=>0);
        }
        echo json_encode($arr);
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
                $html = "<section id='mu-slider'>
                            <div class='mu-slider-single'>
                                <div class='mu-slider-img'>
                                    <figure>
                                        <img src='public/site/assets/img/slider/1.jpg' alt='img'>
                                    </figure>
                                </div>
                            <div class='mu-slider-content'>
                                <h4>{$data->tema}</h4>
                                <span></span>
                                <h2>{$data->judul}</h2>
                                <p>{$data->deskripsi}</p>
                                <div class='slider-action'>  
                                    <a href='{$url_edit}' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>
                                    <a href='{$url_delete}' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></a>
                                </div>
                            </div>
                        </div>
                    </section>";
                return $html;
            })->rawColumns(['slideshow'])
            ->make(true);
    }
}
