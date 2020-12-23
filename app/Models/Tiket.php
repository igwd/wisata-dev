<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Tiket extends Model
{
    protected $table = 'm_tiket';
    protected $primarykey = 'mt_id';
    protected $fillable = ['mt_nama_tiket','mt_keterangan','mt_harga','created_at','updated_at'];
}
