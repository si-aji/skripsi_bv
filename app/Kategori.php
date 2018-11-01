<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'tbl_kategori';

    protected $fillable = [
        "kategori_kode", "kategori_nama", "kategori_slug"
    ];
}
