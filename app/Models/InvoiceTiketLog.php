<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTiketLog extends Model
{
    protected $table = 'invoice_tiket_log';
    protected $primarykey = 'lit_id';
    protected $fillable = ['invoice_tiket_id','status_tiket_id','lit_keterangan','created_at','updated_at'];
}
