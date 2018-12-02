<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $table = 'tbl_paket';

    protected $fillable = [
        "paket_nama", "paket_harga", "paket_status"
    ];

    //Set relation with Paket Item
    public function paketItem(){
        return $this->hasMany('App\PaketItem', 'paket_id');
    }
    //Set relation with PenjualanItem
    public function penjualanItem(){
        return $this->hasMany('App\PenjualanItem', 'penjualan_id');
    }
}
