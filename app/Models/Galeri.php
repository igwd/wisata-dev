<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'm_galeri';
    protected $primarykey = 'id';
    protected $fillable = ['group_kategori','judul','deskripsi','filename'];
}
