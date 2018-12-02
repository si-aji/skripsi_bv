<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanItem extends Model
{
    protected $table = 'tbl_penjualan_item';

    protected $fillable = [
        "penjualan_id", "barang_id", "paket_id", "harga_beli", "harga_jual", "jual_qty", "diskon"
    ];

    //Set relation with Penjualan
    public function penjualan(){
        return $this->belongsTo('App\Penjualan', 'penjualan_id');
    }
    //Set relation with Barang
    public function barang(){
        return $this->belongsTo('App\Barang', 'barang_id');
    }
    //Set relation with Paket
    public function paket(){
        return $this->belongsTo('App\Paket', 'paket_id');
    }
}
