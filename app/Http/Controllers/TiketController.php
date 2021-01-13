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
use PDF;


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
    public function check($token = null)
    {
        $token = str_replace('#', '', $token);
        $token = strtoupper($token);
        $invoice = InvoiceTiket::where('it_kode_unik',$token)->first();
        if(!empty($invoice)){
            $status = InvoiceTiket::TiketStatus($token)->mts_status;
            //dd($status);
            session()->flash('message', array('class'=>'alert-success','text'=>array("<i class='fa fa-check-circle'></i> ".$status)));
            return view('site.tiket.show',compact('invoice'));
        }else{
            session()->flash('message', array('class'=>'alert-danger','text'=>array("<i class='fa fa-times-circle'></i> Tiket #{$token} tidak ditemukan")));
            return view('site.tiket.show',compact('invoice'));
        }
    }

    public function cetak($token)
    {
        //$html2pdf = new HTML2PDF('L','A4','de',false,'UTF-8');
        $invoice = InvoiceTiket::where('it_kode_unik',$token)->first();
        //$doc = view('site.booking.show',compact('invoice'));

        $pdf = PDF::loadview('site.tiket.cetak',['invoice'=>$invoice]);
        $pdf->setPaper([0, 0, 283,465, 141,732], 'landscape');
        return $pdf->stream();

        //return $pdf->download('laporan-pegawai-pdf.pdf');
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