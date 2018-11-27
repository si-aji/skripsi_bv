<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianBayar extends Model
{
    protected $table = 'tbl_pembelian_bayar';

    protected $fillable = [
        "pembelian_id", "user_id", "pembayaran_tgl", "biaya_lain", "diskon", "bayar",
    ];

    //Set relation with Pembelian
    public function pembelian(){
        return $this->belongsTo('App\Pembelian', 'pembelian_id');
    }
    //Set relation with Barang
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
