<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanBayar extends Model
{
    protected $table = 'tbl_penjualan_bayar';

    protected $fillable = [
        "penjualan_id", "user_id", "pembayaran_tgl", "biaya_lain", "bayar",
    ];

    //Set relation with Penjualan
    public function penjualan(){
        return $this->belongsTo('App\Penjualan', 'penjualan_id');
    }
    //Set relation with Barang
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
