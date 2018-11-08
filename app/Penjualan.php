<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'tbl_penjualan';

    protected $fillable = [
        "kostumer_id", "toko_id", "penjualan_invoice", "penjualan_tgl", "penjualan_detail",
    ];

    //Set relation with Kostumer
    public function kostumer(){
        return $this->belongsTo('App\Kostumer', 'kostumer_id');
    }
    //Set relation with Toko
    public function toko(){
        return $this->belongsTo('App\Toko', 'toko_id');
    }

    //Set relation with PenjualanDetail
    public function penjualanDetail(){
        return $this->hasMany('App\PenjualanDetail', 'penjualan_id');
    }
    //Set relation with PenjualanLog
    public function penjualanLog(){
        return $this->hasMany('App\PenjualanLog', 'penjualan_id');
    }
}
