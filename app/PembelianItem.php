<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianItem extends Model
{
    protected $table = 'tbl_pembelian_item';

    protected $fillable = [
        "pembelian_id", "barang_id", "harga_beli", "beli_qty"
    ];

    //Set relation with Pembelian
    public function pembelian(){
        return $this->belongsTo('App\Pembelian', 'pembelian_id');
    }
    //Set relation with Barang
    public function barang(){
        return $this->belongsTo('App\Barang', 'barang_id');
    }
}
