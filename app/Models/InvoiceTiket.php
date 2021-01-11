<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTiket extends Model
{
    protected $table = 'invoice_tiket';
    protected $primarykey = 'it_id';
    protected $fillable = ['it_email','it_telp','it_pemesan','it_tanggal','it_keterangan','it_kode_unik','it_total_tagihan','status_tiket_id','it_jenis_pembayaran','created_at','updated_at'];

    public function invoice_tiket_detail()
    {
        return $this->hasMany(InvoiceTiketDetail::class,'invoice_tiket_id','it_id');
    }
}