<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tiket;
use App\Models\InvoiceTiket;
use App\Models\InvoiceTiketDetail;
use App\Models\InvoiceTiketLog;

use App\Mail\TicketOrder;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;

use Validator;


use DB;

class BookingController extends Controller
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
        $data = (object) array('nama'=>'','telp'=>'','email'=>'','qty'=>array(),'subtotal'=>array(),'metode_bayar'=>2);
        return view('site.tiket.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = new InvoiceTiket;        
        $invoice->it_email = $request->email;
        $invoice->it_telp = $request->telp;
        $invoice->it_pemesan = $request->nama;
        $invoice->it_tanggal = $request->tanggal;
        $invoice->it_kode_unik = $request->_token;
        $invoice->it_jenis_pembayaran = $request->metode_bayar;

        $keterangan = "";
        $total_tagihan = 0;
        //invoice_tiket_id  tiket_id  itd_qty  itd_nominal  itd_subtotal  created_at
        $data_detail = array();
        foreach ($request->qty as $key => $qty) {
            $tiket = Tiket::where('mt_id','=',$key)->firstOrFail();
            $subtotal = $tiket->mt_harga * $qty;
            $total_tagihan += $subtotal;
            if($qty > 0){
                $data_detail[] = array('tiket_id'=>$key,'itd_qty'=>$qty,'itd_nominal'=>$tiket->mt_harga,'itd_subtotal'=>$subtotal);
                $keterangan .= "| {$tiket->mt_nama_tiket} | {$tiket->mt_keterangan} | {$tiket->mt_harga} | {$qty} | {$subtotal} <br>";
            }
        }
        //dd($data_detail);
        $invoice->it_keterangan = $keterangan;
        $invoice->it_total_tagihan = $total_tagihan;
        $invoice->status_tiket_id = 1;

        
        $msg = array();
        
        // setting up rules
        $rules = array(
            'nama' => 'required',
            'email' => 'required',
            'telp' => 'required',
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

        if($total_tagihan <= 0){
            $errors[] = "Anda belum memesan tiket.";
        }
        //dd($errors);

        if(!empty($errors)){
            // send back to the page with the input data and errors
            $msg = array('class'=>'alert-danger','text'=>$errors);
            session()->flash('message', $msg);
        }else{
            //add invoice
            if($invoice->save()){
                $id = $invoice->id;
                //add invoice detail
                $invoice = InvoiceTiket::where('it_id',$id);
                $log = new InvoiceTiketLog;
                $log->invoice_tiket_id = $id;
                $log->status_tiket_id = 1;
                $log->lit_keterangan = 'TIKET DI-PESAN';
                $log->save();
                foreach ($data_detail as $key => $value) {
                    $value['invoice_tiket_id'] = $id;
                    //'invoice_tiket_id','tiket_id','itd_qty','itd_nominal','itd_subtotal','created_at','updated_at'
                    $detail = new InvoiceTiketDetail;
                    $detail->invoice_tiket_id = $id;
                    $detail->tiket_id = $value['tiket_id'];
                    $detail->itd_qty = $value['itd_qty'];
                    $detail->itd_nominal = $value['itd_nominal'];
                    $detail->itd_subtotal = $value['itd_subtotal'];
                    $detail->save();
                }
                $this->sendToEmail($id);
                session()->flash('message', array('class'=>'alert-success','text'=>array('Tiket berhasil dipesan, periksa email yang anda cantumkan untuk verifikasi pesanan.')));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Tiket gagal dipesan')));
            }            
        }

        $data = (object) $request->input();
        if(!empty($errors)){
            return view('site.tiket.create',compact("data"));
        }else{
            return redirect('tiket');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendToEmail($id)
    {
        $invoice = InvoiceTiket::where("it_id","=",$id)->first();
        $mailable = new TicketOrder($invoice);
        Mail::to($invoice->it_email)->send($mailable);
        //return (new TicketOrder($invoice))->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verifikasi($token)
    {
        $token = Crypt::decryptString($token);
        $invoice = InvoiceTiket::where("it_kode_unik","=",$token)->first();
        $invoice->status_tiket_id = 2;
        $invoice_tiket_id = $invoice->it_id;
        if($invoice->it_tanggal <= date('Y-m-d')){
            $update = DB::table('invoice_tiket')
              ->where('it_id', $invoice_tiket_id)
              ->update(['status_tiket_id' => 2,'updated_at'=>date('Y-m-d H:i:s')]);
            if($update){
                $log = new InvoiceTiketLog;
                $log->invoice_tiket_id = $invoice_tiket_id;
                $log->status_tiket_id = 2;
                $log->lit_keterangan = 'TIKET SUDAH DI-VERIFIKASI';
                if($log->save()){
                    return view('site.tiket.show',compact('invoice'));
                }
            }
        }else{
            session()->flash('message', array('class'=>'alert-danger','text'=>array('Tiket tidak dapat di-verifikasi, tanggal booking telah expired')));
            return view('site.tiket.show',compact('invoice'));
        }
        /*//dd($invoice);
        foreach ($invoice->invoice_tiket_detail as $key => $value) {
            echo "<pre>";
            print_r($value->tiket);
            echo "</pre>";
            //echo $value->tiket->mt_nama_tiket."<br>";
        }*/
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

    public function addToCart(Request $request){
        $category = $request->cat;    
        $value = $request->cookie('item');
        $value = (array) json_decode($value);
        
        $index = Crypt::decryptString($request->keyid);

        $kuliner = (empty($value['kuliner']) ? [] : (array) $value['kuliner']);
        $penginapan = (empty($value['penginapan']) ? [] : (array) $value['penginapan']);
        $transport = (empty($value['transport']) ? [] : (array) $value['transport']);

        switch ($category) {
            case 'kuliner':
                $kuliner[$index] = array('keyid'=>$request->keyid,'nama_fasilitas'=>$request->nama_fasilitas,'harga_booking'=>$request->harga_booking);
                break;
            case 'penginapan':
                # code...
                $penginapan[$index] = array('keyid'=>$request->keyid,'nama_fasilitas'=>$request->nama_fasilitas,'harga_booking'=>$request->harga_booking);
                break;
            case 'transportasi':
                # code...
                $transport[$index] = array('keyid'=>$request->keyid,'nama_fasilitas'=>$request->nama_fasilitas,'harga_booking'=>$request->harga_booking);
                break;
        }

        $data['kuliner']=$kuliner;
        $data['penginapan']=$penginapan;
        $data['transport']=$transport;
        $total = count($kuliner)+count($penginapan)+count($transport);
        $data['total'] = $total;

        //$cookie = cookie('name', 'value', $minutes);
        $item = cookie('item',json_encode($data));
        if($item){
            $response = array('success'=>1,'msg'=>'Pesanan berhasil ditambahkan');
        }else{
            $response = array('success'=>2,'msg'=>'Pesanan gagal ditambahkan');
        }
        return response($response)->cookie($item);
    }

    public function getCartItem(Request $request){
        $value = $request->cookie('item');
        $value = json_decode($value);
        return response()->json($value);
    }
}