<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\RateFasilitas;
use DataTables;
use DB;
use Illuminate\Support\Facades\Crypt;


class FasilitasController extends Controller
{
	public function view($kategori=null,Request $request){
		$q = $request->search;
		$group_kategori = "";
		if($kategori == "kuliner"){
			$group_kategori = "TEMPAT_MAKAN";
		}elseif($kategori == "transportasi"){
			$group_kategori = "TRANSPORT";
		}elseif($kategori == "penginapan"){
			$group_kategori = "PENGINAPAN";
		}
        $data = Fasilitas::where('group_kategori','=',$group_kategori)
                ->where(function($query) use ($q){
                    $query->where('nama_fasilitas', 'LIKE', '%' . $q . '%')
                    ->orWhere('alamat_fasilitas', 'LIKE', '%' . $q . '%')
                    ->orWhere('deskripsi', 'LIKE', '%' . $q . '%');
                })->paginate(6);
        $data->appends(['search' => $q]);
        $segment = $kategori;
		return view('site.index-fasilitas', compact('data','segment'));
	}

	public function popular(Request $request){
		$group_kategori = "";
		$kategori = $request->segment(2);
		if($kategori == "kuliner"){
			$group_kategori = "TEMPAT_MAKAN";
		}elseif($kategori == "transportasi"){
			$group_kategori = "TRANSPORT";
		}elseif($kategori == "penginapan"){
			$group_kategori = "PENGINAPAN";
		}
		$qry = RateFasilitas::select('m_fasilitas.id','thumbnail','nama_fasilitas','alamat_fasilitas',DB::raw("ROUND(AVG(rf_skor),1) as skor"))
				->join('m_fasilitas','rate_fasilitas.fasilitas_id','m_fasilitas.id')
				->where('m_fasilitas.group_kategori',$group_kategori)
				->groupBy('fasilitas_id');

		$data = DB::table( DB::raw("({$qry->toSql()}) as sub"))
	    ->mergeBindings($qry->getQuery())->orderBy('skor','DESC')->limit(5)->get();

	    $html = "";
	    foreach ($data as $key => $value) {
	    	$url = url('/')."/fasilitas/{$kategori}/".Crypt::encryptString($value->id)."/detail";
	    	$html .= "<div class=\"media\">
                        <div class=\"media-left\">
                          <a href=\"{$url}\">
                            <img class=\"media-object\" src=\"".url('/').'/'.$value->thumbnail."\" alt=\"img\">
                          </a>
                        </div>
                        <div class=\"media-body\">
                          <h4 class=\"media-heading\"><a href=\"{$url}\">{$value->nama_fasilitas}</a></h4>                      
                          <span class=\"popular-course-price\"><i class=\"fa fa-star\"></i> {$value->skor}</span>
                        </div>
                      </div>";
	    }
		return response()->json($html);
	}

	public function show($kategori,$id,Request $request){
		$keyid = $id;
		$id = Crypt::decryptString($id);
		$data = Fasilitas::AvgRating($id);
		$segment = $request->segment(2);
		return view('site.detail-fasilitas', compact('data','segment','keyid'));
	}
}