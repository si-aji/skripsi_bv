<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    protected $table = 'tbl_toko';

    protected $fillable = [
        "toko_tipe", "toko_nama", "toko_alamat", "toko_link", "toko_kontak"
    ];

    //Set relation with Penjualan
    public function penjualan(){
        return $this->hasMany('App\Penjualan', 'toko_id');
    }
}
