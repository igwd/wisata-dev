<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideShow extends Model
{
    protected $table = 'm_slide_show';

    protected $fillable = ['tema','judul','deskripsi','url_gambar'];
}
