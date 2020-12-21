<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateFasilitas extends Model
{
    protected $table = 'rate_fasilitas';
    protected $primarykey = 'rf_id';
    protected $fillable = ['rf_id','rf_name','rf_email','rf_review','fasilitas_id','rf_skor'];

	public function fasilitas(){
	    return $this->belongsTo('App\Models\Fasilitas', 'id','fasilitas_id');
	}    
}
