<?php

namespace App\Http\Controllers\Admin\Fasilitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use DataTables;
use DB;
use Validator;


class PenginapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fasilitas.penginapan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fasilitas.penginapan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fasilitas = new Fasilitas;
        $url_gambar = $request->url_gambar;
        $fasilitas->nama_fasilitas = $request->nama_fasilitas;
        $fasilitas->group_kategori = $request->group_kategori;
        $fasilitas->mt_harga = $request->harga_booking;
        $fasilitas->deskripsi = $request->deskripsi;
        $fasilitas->alamat_fasilitas = $request->alamat_fasilitas;
        $fasilitas->geo_location = $request->geo_location;
        $msg = array();
        
        // setting up rules
        $rules = array(
            'nama_fasilitas' => 'required',
            'alamat_fasilitas'=> 'required',
            'deskripsi' => 'required',
            'harga_booking'=> 'required',
            'image' => 'mimes:jpeg,jpg,png|required',
            'geo_location'=> 'required'

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
                $destinationPath = 'storage/fasilitas'; // upload path
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
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx'));
            }
        }
        //dd($url_gambar);
        $fasilitas->thumbnail = $url_gambar; $id = null;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            if($fasilitas->save()){
                $id = $fasilitas->id;
                session()->flash('message', array('class'=>'alert-success','text'=>array('Berhasil tambah data Penginapan - '.$request->nama_fasilitas)));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Gagal tambah data Penginapan - '.$request->nama_fasilitas)));
            }
        }
        $data = (object) $request->input();
        if(!empty($errors)){
            return view('admin.fasilitas.penginapan.create',compact("data"));
        }else{
            return redirect('admin/fasilitas/penginapan/'.$id.'/edit');
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
        $data = Fasilitas::where("id","=",$id)->first();
        return view('admin.fasilitas.penginapan.edit',compact('data'));
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
        $fasilitas = Fasilitas::find($id);
        $url_gambar = $request->url_gambar;
        $fasilitas->nama_fasilitas = $request->nama_fasilitas;
        $fasilitas->group_kategori = $request->group_kategori;
        $fasilitas->mt_harga = $request->harga_booking;
        $fasilitas->deskripsi = $request->deskripsi;
        $fasilitas->alamat_fasilitas = $request->alamat_fasilitas;
        $fasilitas->geo_location = $request->geo_location;
        $msg = array();
        $file = array('image' => $request->file('image'));
        // setting up rules
        $rules = array(
            'image' => 'mimes:jpeg,jpg,png|required',
            'nama_fasilitas' => 'required',
            'deskripsi' => 'required',
            'harga_booking'=> 'required',
            'alamat_fasilitas'=> 'required',
            'geo_location'=> 'required'

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
                $destinationPath = 'storage/fasilitas'; // upload path
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
                $msg = array('class'=>'alert-danger','text'=>array('Format File tidak Sesuai, Format File yang diperbolehkan adalah *.jgp,*.jpeg,*.png,*.pdf,*.doc,*.docx'));
            }
        }
        //dd($url_gambar);
        $fasilitas->thumbnail = $url_gambar;
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            $simpan = $fasilitas->save();
            if($simpan){
                session()->flash('message', array('class'=>'alert-success','text'=>array('Berhasil <i>update</i> data Penginapan - '.$request->nama_fasilitas)));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Gagal <i>update</i> data Penginapan - '.$request->nama_fasilitas)));
            }
        }
        return redirect('admin/fasilitas/penginapan/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //dd($request->all());
        $del = Fasilitas::where('id',$id)->delete();
        //$del = true;
        if($del){
            //@unlink($request->file);
            $msg = array('class'=>'alert-success','text'=>'Berhasil hapus data Penginapan #'.$request->nama_fasilitas);
        }else{
            $msg = array('class'=>'alert-danger','text'=>'Gagal hapus data Penginapan #'.$request->nama_fasilitas);
        }
        return response()->json($msg);
    }

    public function listData(Request $request){
        $data = Fasilitas::select([
            'id','thumbnail','group_kategori','nama_fasilitas','alamat_fasilitas','deskripsi','geo_location'
        ])->where('group_kategori','PENGINAPAN');

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('fasilitas', function($query, $keyword) {
                    $sql = "nama_fasilitas like ? OR deskripsi like ?";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('thumbnail',function($data){
                $url_gambar = "";
                if(!empty($data->thumbnail)){
                    $url_gambar = url('/')."/{$data->thumbnail}";
                }else{
                    $url_gambar = url('/')."/public/site/assets/img/slider/1.jpg";
                }

                return "<img width='80%' src='{$url_gambar}'>";
            })
            ->addcolumn('fasilitas', function ($data) {
                $url_edit = url('/')."/admin/fasilitas/penginapan/{$data->id}/edit";
                $url_delete = url('/')."/admin/fasilitas/penginapan/{$data->id}/destroy";
                $html = "<h5>{$data->nama_fasilitas}</h5>
                        <i class='fa fa-map-marker'> {$data->alamat_fasilitas}</i><br>
                        {$data->deskripsi}";
                return $html;
            })
            ->addcolumn('aksi',function($data){
                $url_edit = url('/')."/admin/fasilitas/penginapan/{$data->id}/edit";
                $nama_fasilitas = str_replace("'", "`", $data->nama_fasilitas);
                return "<a href='{$url_edit}' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>
                <a onclick='deleteData(\"{$data->id}\")' id='fasilitas{$data->id}' class='btn btn-sm btn-danger btn-delete' data-id='{$data->id}' data-fasilitas='{$nama_fasilitas}' data-file='{$data->thumnnail}'><i class='fa fa-trash'></i></a>";
            })->rawColumns(['thumbnail','fasilitas','aksi'])
            ->make(true);
    }
}
