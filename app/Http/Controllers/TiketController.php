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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
    }
}