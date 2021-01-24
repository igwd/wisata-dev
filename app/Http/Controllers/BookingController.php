<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tiket;
use App\Models\Fasilitas;
use App\Models\InvoiceTiket;
use App\Models\InvoiceTiketDetail;
use App\Models\InvoiceTiketLog;

use App\Mail\TicketOrder;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Crypt;

use Validator;
use Cookie;
use HTML2PDF;


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
        $value = $request->cookie('item');
        $data = (array) json_decode($value);
        $data['booking'] = array();
        return view('site.booking.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
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

        $booking_name = $request->booking_name;
        $booking_price = $request->booking_price;
        $booking_group = $request->booking_group;
        $booking_subtotal = $request->booking_subtotal;

        $keterangan = "";
        $total_tagihan = 0;

        //invoice_tiket_id  tiket_id  itd_qty  itd_nominal  itd_subtotal  created_at
        $data_detail = array();
        foreach ($request->qty as $key => $qty) {
            $tiket = Tiket::where('mt_id','=',$key)->first();
            if(empty($tiket)){
                $tiket = Fasilitas::where('id','=',$key)->first();
            }
            $subtotal = $tiket->mt_harga * $qty;
            $total_tagihan += $subtotal;
            if($qty > 0){
                $data_detail[] = array(
                    'tiket_id'=>$key,
                    'itd_qty'=>$qty,
                    'itd_nominal'=>$tiket->mt_harga,
                    'itd_subtotal'=>$subtotal,
                    'booking_name'=>$booking_name[$key],
                    'booking_group'=>$booking_group[$key]
                );
                $keterangan .= "| ".(!empty($tiket->mt_nama_tiket) ? $tiket->mt_nama_tiket : $tiket->nama_fasilitas)." | ".(!empty($tiket->mt_keterangan) ? $tiket->mt_keterangan : $tiket->alamat_fasilitas)." | {$tiket->mt_harga} | {$qty} | {$subtotal} @";
            }
        }
        /*echo "<pre>";
        print_r($data_detail);
        echo "</pre>";*/
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
            'metode_bayar'=>'required'
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
            $errors[] = "<i class='fa fa-warning'></i>  Tidak ada pesanan yang diproses, Anda belum memesan tiket atau fasilitas.";
        }
        //dd($errors);
        $token = "";
        if(!empty($errors)){
            // send back to the page with the input data and errors
            $msg = array('class'=>'alert-danger','text'=>$errors);
            session()->flash('message', $msg);
        }else{
            //add invoice
            if($invoice->save()){
                $id = $invoice->id;

                $token = Crypt::encryptString($id);
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
                    $detail->booking_group = $value['booking_group'];
                    $detail->booking_name = $value['booking_name'];
                    $detail->itd_qty = $value['itd_qty'];
                    $detail->itd_nominal = $value['itd_nominal'];
                    $detail->itd_subtotal = $value['itd_subtotal'];
                    $detail->save();
                }
                // generate kode unik transaksi
                $number_of_booking = InvoiceTiket::where('it_tanggal',$request->tanggal)->get()->count();
                $total_trx = $id+$number_of_booking+1;

                $it_kode_unik = strtoupper(date('Ymd').$this->generateCode($total_trx));
                //update kode unik
                $data = InvoiceTiket::where('it_id',$id)->update(array('it_kode_unik'=>$it_kode_unik));
                
                //$this->sendToEmail($id);
                session()->flash('message', array('class'=>'alert-success','text'=>array('Tiket berhasil dipesan')));
            }else{
                session()->flash('message', array('class'=>'alert-danger','text'=>array('Tiket gagal dipesan')));
            }            
        }
        //dd($errors);
        if(empty($errors)){
            $cookie = Cookie::forget('item');
            $invoice = InvoiceTiket::where('it_id',$id)->first();
            return redirect('booking/'.$it_kode_unik.'/verifikasi')->withCookie('item');
            //return view('site.booking.show',compact('invoice'))->withCookie('item');
        }elseif($total_tagihan <= 0){
            $value = $request->cookie('item');
            $data = (array) json_decode($value);
            $data['booking'] = (object) array(
                    'nama'=>$request->nama,
                    'email'=>$request->email,
                    'telp'=>$request->telp,
                    'tanggal'=>$request->tanggal,
                    'metode_bayar'=>$request->metode_bayar
                );
            //dd($data);
            return view('site.booking.index',compact('data'));
        }else{
            $value = $request->cookie('item');
            $data = (array) json_decode($value);
            $data['booking'] = (object) array(
                    'nama'=>$request->nama,
                    'email'=>$request->email,
                    'telp'=>$request->telp,
                    'tanggal'=>$request->tanggal,
                    'metode_bayar'=>$request->metode_bayar
                );
            return view('site.booking.index',compact('data'));
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
        $invoice = InvoiceTiket::where("it_kode_unik","=",$token)->first();
        $invoice->status_tiket_id = 2;
        $invoice_tiket_id = $invoice->it_id;
        if($invoice->it_tanggal >= date('Y-m-d')){
            $update = DB::table('invoice_tiket')
              ->where('it_id', $invoice_tiket_id)
              ->update(['status_tiket_id' => 2,'updated_at'=>date('Y-m-d H:i:s')]);
            if($update){
                $log = new InvoiceTiketLog;
                $log->invoice_tiket_id = $invoice_tiket_id;
                $log->status_tiket_id = 2;
                $log->lit_keterangan = 'TIKET SUDAH DI-VERIFIKASI';
                if($log->save()){
                    return view('site.booking.show',compact('invoice'));
                }
            }
        }else{
            session()->flash('message', array('class'=>'alert-danger','text'=>array('Tiket tidak dapat di-verifikasi, tanggal booking telah expired')));
            return view('site.booking.show',compact('invoice'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment($token)
    {
        $invoice = InvoiceTiket::where("it_kode_unik","=",$token)->first();
        $invoice->status_tiket_id = 2;
        $invoice_tiket_id = $invoice->it_id;
        if($invoice->it_tanggal >= date('Y-m-d')){
            $update = DB::table('invoice_tiket')
              ->where('it_id', $invoice_tiket_id)
              ->update(['status_tiket_id' => 2,'updated_at'=>date('Y-m-d H:i:s')]);
            if($update){
                $log = new InvoiceTiketLog;
                $log->invoice_tiket_id = $invoice_tiket_id;
                $log->status_tiket_id = 2;
                $log->lit_keterangan = 'TIKET SUDAH DI-VERIFIKASI';
                if($log->save()){
                    return view('site.booking.payment',compact('invoice'));
                }
            }
        }else{
            session()->flash('message', array('class'=>'alert-danger','text'=>array('Tiket tidak dapat di-verifikasi, tanggal booking telah expired')));
            return view('site.booking.payment',compact('invoice'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, $id)
    {
        $url_gambar = $request->url_gambar;
        $no_rekening = $request->no_rekening;
        $msg = array();
        $file = array('image' => $request->file('image'));
        // setting up rules
        $rules = array(
            'image' => 'required',
            'no_rekening' => 'required'
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
                $destinationPath = 'storage/invoice'; // upload path
                $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
                $filename = $request->file('image')->getClientOriginalName(); // getting image extension
                $file = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
                $fileName = $id.'.'.$extension;
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
        
        if(empty($url_gambar)){
            session()->flash('message', $msg);
        }else{
            $simpan = DB::table('invoice_tiket')
              ->where('it_kode_unik', $id)
              ->update(['file_bukti'=>$url_gambar,'no_rekening'=>$no_rekening,'status_tiket_id' => 3,'updated_at'=>date('Y-m-d H:i:s')]);
            if($simpan){
                $tiket_id = InvoiceTiket::where('it_kode_unik',$id)->first()->it_id;
                $log = new InvoiceTiketLog;
                $log->invoice_tiket_id = $tiket_id;
                $log->status_tiket_id = 3;
                $log->lit_keterangan = 'TIKET SUDAH DIBAYAR';
                $log->save();

                $msg = array('class'=>'alert-success','text'=>array('Berhasil <i>upload</i> bukti bayar - #'.$id.', silahkan tunggu proses validasi oleh admin.'));
                session()->flash('message', $msg);
            }else{
                $msg = array('class'=>'alert-danger','text'=>array('Gagal <i>upload</i> bukti bayar - #'.$id));
                session()->flash('message', $msg);
            }
        }
        $invoice = InvoiceTiket::where('it_kode_unik',$id)->first();
        $kode = $id;
        if($request->ajax()){
            return response()->json($msg);
        }else{
            return view('site.booking.payment',compact('invoice','kode'));
            //dd($invoice);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function addToCart(Request $request){
        $category = $request->cat;    
        $value = $request->cookie('item');
        $value = (array) json_decode($value);
        
        $index = Crypt::decryptString($request->keyid);

        $kuliner = (empty($value['kuliner']) ? [] : (array) $value['kuliner']);
        $penginapan = (empty($value['penginapan']) ? [] : (array) $value['penginapan']);
        $transport = (empty($value['transport']) ? [] : (array) $value['transport']);
        $tiket = (empty($value['tiket']) ? [] : (array) $value['tiket']);

        switch ($category) {
            case 'kuliner':
                $kuliner[$index] = array('keyid'=>$request->keyid,'booking_name'=>$request->nama_fasilitas,'booking_qty'=>1,'booking_price'=>$request->harga_booking,'booking_subtotal'=>$request->harga_booking);
                break;
            case 'penginapan':
                # code...
                $penginapan[$index] = array('keyid'=>$request->keyid,'booking_name'=>$request->nama_fasilitas,'booking_qty'=>1,'booking_price'=>$request->harga_booking,'booking_subtotal'=>$request->harga_booking);
                break;
            case 'transportasi':
                # code...
                $transport[$index] = array('keyid'=>$request->keyid,'booking_name'=>$request->nama_fasilitas,'booking_qty'=>1,'booking_price'=>$request->harga_booking,'booking_subtotal'=>$request->harga_booking);
                break;
        }

        $data['kuliner']=$kuliner;
        $data['penginapan']=$penginapan;
        $data['transport']=$transport;
        $data['tiket'] = $tiket;
        $total = count($kuliner)+count($penginapan)+count($transport)+count($tiket);
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

    public function addTiketToCart(Request $request){
        $value = $request->cookie('item');
        $value = (array) json_decode($value);
        $kuliner = (empty($value['kuliner']) ? [] : (array) $value['kuliner']);
        $penginapan = (empty($value['penginapan']) ? [] : (array) $value['penginapan']);
        $transport = (empty($value['transport']) ? [] : (array) $value['transport']);
        
        
        $tiket_pesan = (empty($value['tiket']) ? [] : (array) $value['tiket']);
        $tiket_baru = $request->mt_nama_tiket;
        $tiket = array();
        $qty = $request->qty;
        $price = $request->harga;
        $total_tagihan = 0;

        foreach ($tiket_baru as $key => $value) {
            $qty_ = $qty[$key] + @$tiket_pesan[$key]->booking_qty;
            $subtotal_ = $qty_ * $price[$key];
            $total_tagihan += $subtotal_;
            if($subtotal_ < 0){
                $tiket[$key] = array('keyid'=>$key,'booking_name'=>$value,'booking_qty'=>0,'booking_price'=>$price[$key],'booking_subtotal'=>0);  
            }else{
                $tiket[$key] = array('keyid'=>$key,'booking_name'=>$value,'booking_qty'=>$qty_,'booking_price'=>$price[$key],'booking_subtotal'=>$subtotal_);  
            }
        }
        
        $errors = "";
        $data['tiket'] = $tiket;
        if($total_tagihan <= 0){
            $errors = "Anda belum memesan tiket.";
            $data['tiket'] = array();
        }

        $data['kuliner']=$kuliner;
        $data['penginapan']=$penginapan;
        $data['transport']=$transport;
        
        
        $total = count($kuliner)+count($penginapan)+count($transport)+count($data['tiket']);
        $data['total'] = $total;

        $item = cookie('item',json_encode($data));
        if($item){
            if(!empty($errors)){
                $response = array('success'=>2,'msg'=>$errors);
            }else{
                $response = array('success'=>1,'msg'=>'Pesanan berhasil ditambahkan');
            }
        }else{
            $response = array('success'=>3,'msg'=>'Pesanan gagal ditambahkan');
        }
        return response($response)->cookie($item);

    }

    public function getCartItem(Request $request){
        $value = $request->cookie('item');
        $value = json_decode($value);
        return response()->json($value);
    }

    public function generateCode($data){
        $alphabet =   array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        $alpha_flip = array_flip($alphabet);
        if($data <= 25){
            return $alphabet[$data];
        }elseif($data > 25){
            $dividend = ($data + 1);
            $alpha = '';
            $modulo;
            while ($dividend > 0){
                $modulo = ($dividend - 1) % 26;
                $alpha = $alphabet[$modulo] . $alpha;
                $dividend = floor((($dividend - $modulo) / 26));
            } 
            return $alpha;
        }
    }
}