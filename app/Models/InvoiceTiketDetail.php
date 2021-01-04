<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTiketDetail extends Model
{
    protected $table = 'invoice_tiket_detail';
    protected $primarykey = 'itd_id';
    protected $fillable = ['invoice_tiket_id','tiket_id','booking_group','booking_name','itd_qty','itd_nominal','itd_subtotal','created_at','updated_at'];

    
    /*public function tiket()
    {
        return $this->belongsTo(Tiket::class,'tiket_id','mt_id');
    }*/
}
