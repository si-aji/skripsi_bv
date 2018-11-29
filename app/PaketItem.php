<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaketItem extends Model
{
    protected $table = 'tbl_paket_item';

    protected $fillable = [
        "paket_id", "barang_id", "barang_hAsli", "barang_hJual"
    ];

    //Set relation with Paket
    public function paket(){
        return $this->belongsTo('App\Paket', 'paket_id');
    }

    //Set relation with Barang
    public function barang(){
        return $this->belongsTo('App\Barang', 'barang_id');

    }
}
