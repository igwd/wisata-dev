<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'm_fasilitas';
    protected $primarykey = 'id';
    protected $fillable = ['thumbnail','group_kategori','nama_fasilitas','alamat_fasilitas','deskripsi','geo_location'];
}
