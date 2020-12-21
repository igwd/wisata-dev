<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tiket;
use App\Models\InvoiceTiket;
use App\Models\LogInvoiceTiket;

use DB;

class TiketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('site.tiket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galeri.photo.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $galeri = new Galeri;
        $url_gambar = $request->url_gambar;
        $galeri->judul = $request->judul;
        $galeri->group_kategori = $request->group_kategori;
        $galeri->deskripsi = $request->deskripsi;

        $msg = array();
        
        // setting up rules
        $rules = array(
            'judul' => 'required',
            'deskripsi' => 'required',
            'image' => 'required',
        ); 

        $messages = [
            'required' => '<i class="fa fa-times"></i> Kolom :attribute tidak diperkenankan Kosong',
            'min' => '<i class="fa fa-times"></i> Kolom :attribute tidak diperkenankan kurang dari :min karakter',
            'max' => '<i class="fa fa-times"></i> Kolom :attribute tidak diperkenankan lebih dari :max karakter',
            'without_spaces' => '<i class="fa fa-times"></i>  Kolom :attribute kidak diperkenankan ada spasi',
            'unique' => '<i class="fa fa-times"></i>  Kolom :attribute sudah terdaftar',
            'email' => '<i class="fa fa-times"></i> Alamat email tidak valid.',
            'numeric'=> '<i class="fa fa-times"></i> Kolom :attribute input harus angka',
            'confirmed' => '<i class="fa fa-times"></i>  Kolom :attribute tidak sesuai dengan konfirmasi password',
        ];
        
        $v = Validator::make($request->all(), $rules, $messages);
        $errors = array();
        foreach ($v->messages()->toArray() as $err => $errvalue) {
            $errors = array_merge($errors, $errvalue);
        }
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        
        if(!empty($errors)){
            // send back to the page with the input data and errors
            $msg = array('class'=>'alert-danger','text'=>$errors);
        }else{
            // checking file is valid.
            if ($request->file('image')->isValid()) {
                $destinationPath = 'storage/galeri/photo'; // upload path
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
                    $img_fit = Image::make($url_gambar);
                    $img_fit->fit(2048, 1365);
                    $img_fit->save($url_gambar);
                }
            }else{
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx'));
            }
        }
        //dd($url_gambar);
        $galeri->filename = $url_gambar; $id = null;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            // lets make thumbnail
            $img_thumb = Image::make($url_gambar);
            $img_thumb_path = $img_thumb->dirname.'/thumb';
            $img_thumb_name = $img_thumb->basename;
            $img_thumb_extension = $img_thumb->extension;
            $img_thumb->fit(370, 220);
            $img_thumb->save($img_thumb_path.'/thumb_'.$img_thumb_name);

            $galeri->thumbnail = $img_thumb_path.'/thumb_'.$img_thumb_name;

            if($galeri->save()){
                $id = $galeri->id;
                session()->flash('message', array('class'=>'alert-success','text'=>array('Berhasil tambah data Galeri Photo - '.$request->judul)));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Gagal tambah data Galeri Photo - '.$request->judul)));
            }
        }
        $data = (object) $request->input();
        if(!empty($errors)){
            return view('admin.galeri.photo.create',compact("data"));
        }else{
            return redirect('admin/galeri/photo/'.$id.'/edit');
        }
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
        $data = Galeri::where("id","=",$id)->first();
        return view('admin.galeri.photo.edit',compact('data'));
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
        $galeri = Galeri::find($id);
        $url_gambar = $request->url_gambar;
        $galeri->judul = $request->judul;
        $galeri->group_kategori = $request->group_kategori;
        $galeri->deskripsi = $request->deskripsi;

        $msg = array();
        $file = array('image' => $request->file('image'));
        // setting up rules
        $rules = array(
            'image' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
        ); 

        $messages = [
            'required' => '<i class="fa fa-times"></i> Kolom :attribute tidak diperkenankan Kosong',
            'min' => '<i class="fa fa-times"></i> Kolom :attribute tidak diperkenankan kurang dari :min karakter',
            'max' => '<i class="fa fa-times"></i> Kolom :attribute tidak diperkenankan lebih dari :max karakter',
            'without_spaces' => '<i class="fa fa-times"></i>  Kolom :attribute kidak diperkenankan ada spasi',
            'unique' => '<i class="fa fa-times"></i>  Kolom :attribute sudah terdaftar',
            'email' => '<i class="fa fa-times"></i> Alamat email tidak valid.',
            'numeric'=> '<i class="fa fa-times"></i> Kolom :attribute input harus angka',
            'confirmed' => '<i class="fa fa-times"></i>  Kolom :attribute tidak sesuai dengan konfirmasi password',
        ];
        
        $v = Validator::make($request->all(), $rules, $messages);
        $errors = array();
        foreach ($v->messages()->toArray() as $err => $errvalue) {
            $errors = array_merge($errors, $errvalue);
        }
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        
        if(!empty($errors)){
            // send back to the page with the input data and errors
            $msg = array('class'=>'alert-danger','text'=>$errors);
        }else{
            // checking file is valid.
            if ($request->file('image')->isValid()) {
                $destinationPath = 'storage/galeri/photo'; // upload path
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
                    //2048x1365
                    $img_fit = Image::make($url_gambar);
                    $img_fit->fit(2048, 1365);
                    $img_fit->save($url_gambar);
                }
            }else{
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx'));
            }
        }
        //dd($url_gambar);
        $galeri->filename = $url_gambar;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            // lets make thumbnail
            $img_thumb = Image::make($url_gambar);
            $img_thumb_path = $img_thumb->dirname.'/thumb';
            $img_thumb_name = $img_thumb->basename;
            $img_thumb_extension = $img_thumb->extension;
            
            $img_thumb->fit(370, 220);
            $img_thumb->save($img_thumb_path.'/thumb_'.$img_thumb_name);

            $galeri->thumbnail = $img_thumb_path.'/thumb_'.$img_thumb_name;

            $simpan = $galeri->save();
            if($simpan){
                session()->flash('message', array('class'=>'alert-success','text'=>array('Berhasil <i>update</i> data Galeri Photo - '.$request->judul)));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Gagal <i>update</i> data Galeri Photo - '.$request->judul)));
            }
        }
        return redirect('admin/galeri/photo/'.$id.'/edit');
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
    }
}