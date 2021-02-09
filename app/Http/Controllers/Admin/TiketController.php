<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceTiket;
use App\Models\InvoiceTiketDetail;
use App\Models\InvoiceTiketLog;
use App\Models\Tiket;
use App\Models\Fasilitas;

use DataTables;
use DB;
use Validator;


class TiketController extends Controller
{

    /**
     * Display a listing of the resource.
     * Index Transaksi Admin
     * @return \Illuminate\Http\Response
     */
    public function indexTransaksi(Request $request)
    {
        //dd($request->session());
        $user = $request->session()->get('user');
        $data['booking'] = (object) array(
            'nama'=>$user['name'],
            'email'=>$user['email'],
            'telp'=>'-'
        );
        $data['tiket'] = (object) array();
        $data['kuliner'] = (object) array();
        $data['penginapan'] = (object) array();
        $data['transport'] = (object) array();
        return view('admin.tiket.index-transaksi-admin',compact('data'));
    }

    public function listDataFasilitas(Request $request){
        $data = Fasilitas::select([
            'id','thumbnail','group_kategori','nama_fasilitas','alamat_fasilitas','deskripsi','geo_location','mt_harga',
        ])->where('group_kategori',$request->group_kategori);
        
        $selected = array();
        if($request->selected != "null"){
            $selected = json_decode($request->selected);
        }

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('fasilitas', function($query, $keyword) {
                    $sql = "nama_fasilitas like ? OR deskripsi like ?";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('fasilitas', function ($data) {
                $url_edit = url('/')."/admin/fasilitas/penginapan/{$data->id}/edit";
                $url_delete = url('/')."/admin/fasilitas/penginapan/{$data->id}/destroy";
                $html = "<h5>{$data->nama_fasilitas}</h5>
                        <i class='fa fa-map-marker'> {$data->alamat_fasilitas}</i><br>
                        {$data->deskripsi}";
                return $html;
            })
            ->addcolumn('aksi',function($data) use ($request,$selected){
                //$url_edit = url('/')."/admin/fasilitas/penginapan/{$data->id}/edit";
                if(in_array($data->id, $selected)){
                    $add = FALSE;
                }else{
                    $add = TRUE;
                }
                $nama_fasilitas = str_replace("'", "`", $data->nama_fasilitas);
                $datajson = json_encode(
                    array(
                        'tiket_id'=>$data->id,
                        'itd_qty'=>1,
                        'itd_nominal'=>$data->mt_harga,
                        'itd_subtotal'=>$data->mt_harga,
                        'booking_name'=>$data->nama_fasilitas,
                        'booking_group'=>$request->group_kategori
                    ));
                return "<a onclick='pilihFasilitas({$datajson},{$add})' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Pilih</a>";
            })->rawColumns(['fasilitas','aksi'])
            ->make(true);
    }

    public function modalDataFasilitas(Request $request){
        $title = "";
        switch ($request->group_kategori) {
            case 'TEMPAT_MAKAN':
                $title = "Kuliner";
                break;
            case 'PENGINAPAN':
                $title = "Penginapan";
                break;
            case 'TRANSPORT':
                $title = "Transport";
                break;
            default:
                $title = "Kuliner";
                break;
        }
        $group_kategori = $request->group_kategori;
        $index = $request->index;
        $selected = json_encode($request->selected);
        return view('admin.tiket.modal-fasilitas',compact('group_kategori','title','index','selected'))->render();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.tiket.index',compact('data'));
    }

    public function listData(Request $request){
        $data = InvoiceTiket::select(['it_id',
            'it_email','it_telp','it_pemesan','it_tanggal','it_keterangan','it_kode_unik','it_total_tagihan','status_tiket_id','it_jenis_pembayaran','file_bukti','no_rekening','mts_status'
        ])->leftjoin('m_tiket_status','status_tiket_id','m_tiket_status.mts_id')->orderBy('status_tiket_id','ASC');

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('tiket', function($query, $keyword) {
                    $sql = "it_pemesan like ? OR it_email like ? OR it_telp like ? OR it_kode_unik like ?";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%","%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('thumbnail',function($data){
                $url_gambar = "";
                if(!empty($data->file_bukti)){
                    $url_gambar = url('/')."/{$data->file_bukti}";
                }else{
                    $url_gambar = url('/')."/public/site/assets/img/slider/1.jpg";
                }

                return "<img width='80%' src='{$url_gambar}'>";
            })
            ->addcolumn('tiket', function ($data) {
                $detail = InvoiceTiketDetail::where('invoice_tiket_id',$data->it_id)->get();
                $keterangan = "<ul>";
                foreach ($detail as $key => $value) {
                    $keterangan .= "<li><small style='font-size:60%'>[ {$value->booking_group} ]</small> {$value->booking_name} <small style='font-size:80%'>($value->itd_qty x ".number_format($value->itd_nominal)." = ".number_format($value->itd_subtotal).")</small></li>";
                }
                $keterangan .= "</ul>";
                $html = "<h5>#{$data->it_kode_unik}</h5>
                        <p><small>$data->it_tanggal</small><br>$data->it_pemesan<br>$data->it_email<br>$data->it_telp<br><b>".number_format($data->it_total_tagihan)."</b><br><span class='btn btn-sm btn-success'>$data->mts_status</span></p>
                        {$keterangan}";
                return $html;
            })
            ->addcolumn('aksi',function($data){
                //$url_edit = url('/')."/admin/fasilitas/penginapan/{$data->id}/edit";
                return "<a style='min-width:200px' class='btn btn-sm btn-success' onclick='approveBuktiBayar(\"$data->it_id\")' id='btn-approve{$data->it_id}' data-id='{$data->it_id}' data-kode='{$data->it_kode_unik}'><i class='fa fa-check'></i> Approve Bukti Bayar</a><br>
                <a onclick='formUploadBuktiBayar(\"$data->it_kode_unik\")' style='min-width:200px' class='btn btn-sm btn-primary'><i class='fa fa-upload'></i> Upload Bukti Bayar</a><br>
                <a onclick='deleteTiket(\"$data->it_kode_unik\")' style='min-width:200px' class='btn btn-sm btn-danger btn-delete' data-kode='{$data->it_kode_unik}'><i class='fa fa-trash'></i> Hapus Tiket</a>";
            })->rawColumns(['thumbnail','tiket','aksi'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->session()->get('user');
        $invoice = new InvoiceTiket;        
        $invoice->it_email = $user['email'];
        $invoice->it_telp = '-';
        $invoice->it_pemesan = $user['name'];
        $invoice->it_tanggal = $request->tanggal;
        $invoice->it_kode_unik = $request->_token;
        $invoice->it_jenis_pembayaran = 1;

        $booking_name = $request->booking_name;
        $booking_price = $request->harga;
        $booking_group = $request->booking_group;
        $booking_subtotal = $request->subtotal;
        $booking_id = $request->booking_id;

        $keterangan = "";
        $total_tagihan = 0;

        //invoice_tiket_id  tiket_id  itd_qty  itd_nominal  itd_subtotal  created_at
        $data_detail = array();
        foreach ($request->qty as $key => $qty) {
            if(!empty($qty)){
                $tiket = Tiket::where('mt_id','=',$booking_id[$key])->first();
                if(empty($tiket)){
                    $tiket = Fasilitas::where('id','=',$booking_id[$key])->first();
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
        }

        $invoice->it_keterangan = $keterangan;
        $invoice->it_total_tagihan = $total_tagihan;
        $invoice->status_tiket_id = 4;

        $datapost = $request->all();
        $datapost['nama'] = $user['name'];
        $datapost['email'] = $user['email'];
        $msg = array();
        
        // setting up rules
        $rules = array(
            'nama' => 'required',
            'email' => 'required',
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
        
        $v = Validator::make($datapost, $rules, $messages);
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
        }else{
            //add invoice
            if($invoice->save()){
                $id = $invoice->id;
                //add invoice detail
                $invoice = InvoiceTiket::where('it_id',$id);
                $log = new InvoiceTiketLog;
                $log->invoice_tiket_id = $id;
                $log->status_tiket_id = 4;
                $log->lit_keterangan = 'PEMBAYARAN DITERIMA';
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
                $msg = array('kode'=>$it_kode_unik,'class'=>'alert-success','text'=>array('Tiket berhasil dipesan, kode tiket #'.$it_kode_unik));
            }else{
                $msg = array('kode'=>'-','class'=>'alert-danger','text'=>array('Tiket gagal dipesan'));
            }            
        }
        
        return response()->json($msg);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del = InvoiceTiket::where('it_kode_unik',$id)->delete();
        if($del){
            //@unlink($request->file);
            $msg = array('class'=>'alert-success','text'=>'Berhasil hapus data Tiket #'.$id);
        }else{
            $msg = array('class'=>'alert-danger','text'=>'Gagal hapus data Tiket #'.$id);
        }
        return response()->json($msg);
    }

    /**
     * Approve bukti bayar, update status tiket
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveBuktiBayar(Request $request, $id){
        $update = DB::table('invoice_tiket')
              ->where('it_id', $id)
              ->update(['status_tiket_id' => 4,'updated_at'=>date('Y-m-d H:i:s')]);
        if($update){
            $log = new InvoiceTiketLog;
            $log->invoice_tiket_id = $id;
            $log->status_tiket_id = 4;
            $log->lit_keterangan = 'PEMBAYARAN DITERIMA';
            if($log->save()){
                return response()->json([
                    'class' => 'alert-success',
                    'text' => 'Proses approve pembayaran #'.$request->it_kode_unik.' berhasil.',
                ]);
            }else{
                return response()->json([
                    'class' => 'alert-danger',
                    'text' => 'Proses approve pembayaran #'.$request->it_kode_unik.' gagal.',
                ]);
            }
        }
    }

    public function formUploadBuktiBayar(Request $request){
        $kode = $request->it_kode_unik;
        $invoice = InvoiceTiket::where('it_kode_unik',$kode)->first();
        return view('admin.tiket.modal-upload-bukti',compact('invoice'));
    }

    // menu cetak tiket
    public function indexCetak(Request $request)
    {
        return view('admin.tiket.index-cetak',compact('data'));
    }

    public function listDataCetakTiket(Request $request){
        $data = InvoiceTiket::select(['it_id',
            'it_email','it_telp','it_pemesan','it_tanggal','it_keterangan','it_kode_unik','it_total_tagihan','status_tiket_id','it_jenis_pembayaran','file_bukti','no_rekening','mts_status'
        ])->leftjoin('m_tiket_status','status_tiket_id','m_tiket_status.mts_id')
        ->where('status_tiket_id',4);

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('tiket', function($query, $keyword) {
                    $sql = "it_pemesan like ? OR it_email like ? OR it_telp like ? OR it_kode_unik like ?";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%","%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('thumbnail',function($data){
                $url_gambar = "";
                if(!empty($data->file_bukti)){
                    $url_gambar = url('/')."/{$data->file_bukti}";
                }else{
                    $url_gambar = url('/')."/public/site/assets/img/slider/1.jpg";
                }

                return "<img width='80%' src='{$url_gambar}'>";
            })
            ->addcolumn('tiket', function ($data) {
                $detail = InvoiceTiketDetail::where('invoice_tiket_id',$data->it_id)->get();
                $keterangan = "<ul>";
                foreach ($detail as $key => $value) {
                    $keterangan .= "<li><small style='font-size:60%'>[ {$value->booking_group} ]</small> {$value->booking_name} <small style='font-size:80%'>($value->itd_qty x ".number_format($value->itd_nominal)." = ".number_format($value->itd_subtotal).")</small></li>";
                }
                $keterangan .= "</ul>";
                $html = "<h5>#{$data->it_kode_unik}</h5>
                        <p><small>$data->it_tanggal</small><br>$data->it_pemesan<br>$data->it_email<br>$data->it_telp<br><b>".number_format($data->it_total_tagihan)."</b><br><span class='btn btn-sm btn-success'>$data->mts_status</span></p>
                        {$keterangan}";
                return $html;
            })
            ->addcolumn('aksi',function($data){
                $url_cetak = url('/')."/tiket/{$data->it_kode_unik}/cetak";
                return "<a target='_blank' href='{$url_cetak}' style='min-width:200px' class='btn btn-sm btn-danger'><i class='fa fa-file-pdf-o'></i> Cetak Tiket</a>";
            })->rawColumns(['thumbnail','tiket','aksi'])
            ->make(true);
    }

    public function indexSettingTiket(Request $request){
        return view('admin.tiket.index-setting',compact('data'));
    }

    public function listDataMasterTiket(Request $request){
        $data = Tiket::all();

        $datatables = DataTables::of($data);
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('tiket', function($query, $keyword) {
                    $sql = "mt_nama_tiket like ? OR mt_deskripsi like ? ";
                    $query->whereRaw($sql, ["%{$keyword}%","%{$keyword}%"]);
                });
        }
        return $datatables
            ->addcolumn('aksi',function($data){
                return "<a onclick='showFormData(\"$data->mt_id\")' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></a><br>
                <a onclick='deleteTiket(\"{$data->mt_id}\")' id='btn-delete{$data->mt_id}' class='btn btn-sm btn-danger btn-delete' data-nama='{$data->mt_nama_tiket}'><i class='fa fa-trash'></i></a>";
            })->rawColumns(['mt_nama_tiket','mt_keterangan','mt_harga','aksi'])
            ->make(true);
    }

    public function editMasterTiket($id){
        $tiket = Tiket::where('mt_id',$id)->first();
        $method = 'PUT';
        $action = url('/')."/admin/tiket/setting/{$id}/update";
        return view('admin.tiket.form-setting',compact('tiket','method','action'));
    }

    public function createMasterTiket(){
        $tiket = null;
        $method = 'POST';
        $action = url('/')."/admin/tiket/setting/store";
        return view('admin.tiket.form-setting',compact('tiket','method','action'));
    }

    public function storeMasterTiket(Request $request){
        $tiket = new Tiket;
        $tiket->mt_nama_tiket = $request->mt_nama_tiket;
        $tiket->mt_keterangan = $request->mt_keterangan;
        $tiket->mt_harga = $request->mt_harga;
        if($tiket->save()){
            return response()->json([
                'class' => 'alert-success',
                'text' => 'Tambah data Tiket '.$request->mt_nama_tiket.' berhasil.',
            ]);
        }else{
            return response()->json([
                'class' => 'alert-danger',
                'text' => 'Tambah data Tiket '.$request->mt_nama_tiket.' gagal.',
            ]);
        }
    }

    public function updateMasterTiket(Request $request, $id){
        $update = DB::table('m_tiket')
              ->where('mt_id', $id)
              ->update(['mt_nama_tiket' => $request->mt_nama_tiket,'mt_keterangan'=>$request->mt_keterangan,'mt_harga'=>$request->mt_harga,'updated_at'=>date('Y-m-d H:i:s')]);
        if($update){
            return response()->json([
                'class' => 'alert-success',
                'text' => 'Update data Tiket '.$request->mt_nama_tiket.' berhasil.',
            ]);
        }else{
            return response()->json([
                'class' => 'alert-danger',
                'text' => 'Update data Tiket '.$request->mt_nama_tiket.' gagal.',
            ]);
        }
    }

    public function destroyMasterTiket(Request $request,$id){
        $del = Tiket::where('mt_id',$id)->delete();
        //$del = true;
        if($del){
            //@unlink($request->file);
            $msg = array('class'=>'alert-success','text'=>'Berhasil hapus data Tiket #'.$request->mt_nama_tiket);
        }else{
            $msg = array('class'=>'alert-danger','text'=>'Gagal hapus data Tiket #'.$request->mt_nama_tiket);
        }
        return response()->json($msg);
    }
}
