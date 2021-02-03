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
		return view('site.fasilitas.index', compact('data','segment'));
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
		return view('site.fasilitas.detail', compact('data','segment','keyid'));
	}

	public function showModalRating($id_enkrip,Request $request){
		$group_kategori = ""; $id = 0;
		$kategori = $request->segment(2);
		//$id_enkrip = $request->keyid;
		if($kategori == "kuliner"){
			$group_kategori = "TEMPAT_MAKAN";
		}elseif($kategori == "transportasi"){
			$group_kategori = "TRANSPORT";
		}elseif($kategori == "penginapan"){
			$group_kategori = "PENGINAPAN";
		}

		$method = 'POST';
        $action = url('/')."/fasilitas/rating/store";
        // proses decrypt id
        $id = Crypt::decryptString($id_enkrip);
        $fasilitas = Fasilitas::find($id);
        $fasilitas = (object) array(
        				'fasilitas_id'=>$fasilitas->id,
        				'nama_fasilitas'=>$fasilitas->nama_fasilitas,
        				'skor'=>$request->skor
    				);
        //dd($fasilitas);
        // return view with data
        return view('site.fasilitas.modal-rating',compact('fasilitas','method','action'));
	}

	public function submitRating(Request $request){
		//dd($request->all());
		$rate = new RateFasilitas;
        $rate->rf_name = $request->rf_name;
        $rate->rf_email = $request->rf_email;
        $rate->rf_review = $request->rf_review;
        $rate->fasilitas_id = $request->fasilitas_id;
        $rate->rf_skor = $request->skor;
		RateFasilitas::where('fasilitas_id',$request->fasilitas_id)->where('rf_email',$request->rf_email)->delete();
        if($rate->save()){
            return response()->json([
                'class' => 'alert-success',
                'text' => 'Review '.$request->nama_fasilitas.' berhasil. Terimakasih telah memberi skor '.$request->skor.' bintang.',
            ]);
        }else{
            return response()->json([
                'class' => 'alert-danger',
                'text' => 'Review '.$request->nama_fasilitas.' gagal.',
            ]);
        }
	}
}