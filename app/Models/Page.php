<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'm_halaman_web';

    protected $fillable = ['group','icon','judul','konten','site_url','is_use_style'];
}
