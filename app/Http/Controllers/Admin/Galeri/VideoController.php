<?php

namespace App\Http\Controllers\Admin\Galeri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use DataTables;
use DB;
use Validator;
use Intervention\Image\Facades\Image;


class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //WHERE group_kategori = 'VIDEO' AND (judul like %% OR deskripsi like %%);
        $q = $request->search;
        $data = Galeri::where('group_kategori','=',DB::raw('"VIDEO"'))
                ->where(function($query) use ($q){
                    $query->where('judul', 'LIKE', '%' . $q . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $q . '%');
                })->paginate(6);
        $data->appends(['search' => $q]);
        return view('admin.galeri.video.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.galeri.video.create',compact('data'));
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
        $url_video = $request->url_video;
        $galeri->judul = $request->judul;
        $galeri->group_kategori = $request->group_kategori;
        $galeri->deskripsi = $request->deskripsi;

        $msg = array();
        
        // setting up rules
        $file = array('judul'=>$request->judul,'deskripsi'=>$request->deskripsi,'image' => $request->file('image'),'video'=>$request->file('video'));
        // setting up rules
        $rules = array(
            'judul' => 'required',
            'deskripsi' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
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
            session()->flash('message', $msg);
        }else{
            // checking file is valid.
            if ($request->file('image')->isValid()) {
                $destinationPath = 'storage/galeri/video/thumbnail'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                $fileName = md5($file).'.'.$extension;
                if (file_exists($url_gambar)) {
                    unlink($url_gambar);
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
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png'));
                session()->flash('message', $msg);
            }


            if ($request->file('video')->isValid()) {
                $destinationPathVideo = 'storage/galeri/video'; // upload path
                $extensionVideo = $request->file('video')->getClientOriginalExtension(); // getting image extension
                $filenameVideo = $request->file('video')->getClientOriginalName(); // getting image extension
                $fileVideo = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filenameVideo);
                $fileNameVideo = md5($file).'.'.$extensionVideo;
                /*if (file_exists($destinationPathVideo.'/'.$fileNameVideo)) {
                    unlink($destinationPathVideo.'/'.$fileNameVideo);
                }*/

                // uploading file to given path
                if ($request->file('video')->move($destinationPathVideo, $fileNameVideo)) {
                    $filePathVideo = $destinationPathVideo.'/'.$fileNameVideo;
                    $url_video = $filePathVideo;
                }
            }else{
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.mp4'));
                session()->flash('message', $msg);
            }
        }
        //dd($url_gambar);

        $galeri->thumbnail = $url_gambar;
        $galeri->filename = $url_video;
        $id = null;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            if($galeri->save()){
                $id = $galeri->id;
                session()->flash('message', array('class'=>'alert-success','text'=>array('Berhasil tambah data Galeri Video - '.$request->judul)));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Gagal tambah data Galeri Video - '.$request->judul)));
            }
        }
        $data = (object) $request->input();
        if(!empty($errors)){
            return view('admin.galeri.video.create',compact("data"));
        }else{
            return redirect('admin/galeri/video/'.$id.'/edit');
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
        return view('admin.galeri.video.edit',compact('data'));
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
        //dd($request->all());
        $galeri = Galeri::find($id);
        $url_gambar = $request->url_gambar;
        $url_video = $request->url_video;
        $galeri->judul = $request->judul;
        $galeri->group_kategori = $request->group_kategori;
        $galeri->deskripsi = $request->deskripsi;

        $msg = array();
        $file = array('judul'=>$request->judul,'deskripsi'=>$request->deskripsi,'image' => $request->file('image'),'video'=>$request->file('video'));
        // setting up rules
        $rules = array(
            'judul' => 'required',
            'deskripsi' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',
            'video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
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
        
        $v = Validator::make($file, $rules, $messages);
        $errors = array();
        foreach ($v->messages()->toArray() as $err => $errvalue) {
            $errors = array_merge($errors, $errvalue);
        }
        //dd($request->file('video')->isValid());
        //mimes:jpeg,bmp,png and for max size max:10000
        // doing the validation, passing post data, rules and the messages
        //dd($errors);
        if(!empty($errors)){
            // send back to the page with the input data and errors
            $msg = array('class'=>'alert-danger','text'=>$errors);
            session()->flash('message', $msg);
        }else{
            // checking file is valid.
            if ($request->file('image')->isValid()) {
                $destinationPath = 'storage/galeri/video/thumbnail'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                $fileName = md5($file).'.'.$extension;
                if (file_exists($url_gambar)) {
                    unlink($url_gambar);
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
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png'));
                session()->flash('message', $msg);
            }


            if ($request->file('video')->isValid()) {
                $destinationPathVideo = 'storage/galeri/video'; // upload path
                $extensionVideo = $request->file('video')->getClientOriginalExtension(); // getting image extension
                $filenameVideo = $request->file('video')->getClientOriginalName(); // getting image extension
                $fileVideo = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filenameVideo);
                $fileNameVideo = md5($file).'.'.$extensionVideo;
                /*if (file_exists($destinationPathVideo.'/'.$fileNameVideo)) {
                    unlink($destinationPathVideo.'/'.$fileNameVideo);
                }*/

                // uploading file to given path
                if ($request->file('video')->move($destinationPathVideo, $fileNameVideo)) {
                    $filePathVideo = $destinationPathVideo.'/'.$fileNameVideo;
                    $url_video = $filePathVideo;
                }
            }else{
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.mp4'));
                session()->flash('message', $msg);
            }
        }
        //dd($url_video);
        //dd($url_gambar);
        $galeri->thumbnail = $url_gambar;
        $galeri->filename = $url_video;
        //dd($msg);
        if(!empty($errors)){
            session()->flash('message', $msg);
        }else{
            // lets make thumbnail
            $img_thumb = Image::make($url_gambar);
            //dd($img_thumb);
            $img_thumb_path = $img_thumb->dirname.'';
            $img_thumb_name = $img_thumb->basename;
            $img_thumb_extension = $img_thumb->extension;
            
            $img_thumb->fit(370, 220);
            $img_thumb->save($img_thumb_path.'/thumb_'.$img_thumb_name);

            $galeri->thumbnail = $img_thumb_path.'/thumb_'.$img_thumb_name;
            $galeri->filename = $url_video;

            $simpan = $galeri->save();
            if($simpan){
                session()->flash('message', array('class'=>'alert-success','text'=>array('Berhasil <i>update</i> data Galeri Video - '.$request->judul)));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Gagal <i>update</i> data Galeri Video - '.$request->judul)));
            }
        }
        return redirect('admin/galeri/video/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //dd($request->all());
        $del = Galeri::where('id',$id)->delete();
        //$del = true;
        if($del){
            @unlink($request->file);
            $msg = array('class'=>'alert-success','text'=>'Berhasil hapus data Galeri #'.$request->judul);
        }else{
            $msg = array('class'=>'alert-danger','text'=>'Gagal hapus data Galeri #'.$request->judul);
        }
        return response()->json($msg);
    }
}
