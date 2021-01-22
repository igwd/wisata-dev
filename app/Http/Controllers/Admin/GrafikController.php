<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InvoiceTiket;
use App\Models\InvoiceTiketDetail;
use DB;

class GrafikController extends Controller
{
    /**
     * Display a listing of the resource.
     * Index Transaksi Admin
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.grafik.index');
    }

    public function dataKunjungan(Request $request){
    	if(empty($request->tahun)){
    		$tahun = date('Y');
    	}else{
    		$tahun  = $request->tahun;
    	}
    	$data = InvoiceTiket::select(
	    			DB::raw("MONTHNAME(it_tanggal) AS bulan"),
	    			'booking_name as category',
	    			DB::raw("SUM(itd_qty) AS qty"),
	    			DB::raw("SUM(itd_subtotal) AS nominal"),
	    			'it_jenis_pembayaran',
	    			DB::raw("IF(it_jenis_pembayaran=1,'Cash','Transfer') AS jenis_pembayaran")		
    			)
    			->join('invoice_tiket_detail','invoice_tiket.it_id','invoice_tiket_detail.invoice_tiket_id')
    			->whereRaw("YEAR(it_tanggal) = {$tahun}")
    			->where('booking_group','TIKET')
    			->groupBy(DB::RAW("MONTHNAME(it_tanggal)"),'booking_name','it_jenis_pembayaran')
    			->orderBy(DB::RAW("MONTH(it_tanggal)"),'asc')
    			->orderBy('booking_name','asc')
    			->orderBy('it_jenis_pembayaran','asc')
    			->get()->toArray();
    	return response()->json($data);
    }
}
