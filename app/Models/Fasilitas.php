<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Fasilitas extends Model
{
    protected $table = 'm_fasilitas';
    protected $primarykey = 'id';
    protected $fillable = ['thumbnail','group_kategori','nama_fasilitas','alamat_fasilitas','deskripsi','mt_harga','geo_location'];

    /**
     * Get the rating for the facilities.
     */
    public function rating()
    {
        return $this->hasMany(RateFasilitas::class,'fasilitas_id','id');
    }

    public function scopeAvgRating($query,$id){
        return $query->select('a.*',DB::raw("ROUND(AVG(b.rf_skor),1) as skor"))
            ->from('m_fasilitas as a')
            ->leftjoin('rate_fasilitas as b','a.id','b.fasilitas_id')
            ->where('a.id',$id)
            ->groupBy('a.id')
            ->first();
    }
}
