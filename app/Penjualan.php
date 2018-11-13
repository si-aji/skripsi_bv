<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'tbl_penjualan';

    protected $fillable = [
        "kostumer_id", "toko_id", "penjualan_invoice", "penjualan_tgl", "penjualan_detail",
    ];

    public function getCreatedAtAttribute($created_at){
        return date("M", strtotime($created_at))." ".date("d", strtotime($created_at)).", ".date("Y", strtotime($created_at))." / ".date("H", strtotime($created_at)).":".date("i", strtotime($created_at)).":".date("s", strtotime($created_at))." WIB";
    }
    public function getUpdatedAtAttribute($updated_at){
        return date("M", strtotime($updated_at))." ".date("d", strtotime($updated_at)).", ".date("Y", strtotime($updated_at))." / ".date("H", strtotime($updated_at)).":".date("i", strtotime($updated_at)).":".date("s", strtotime($updated_at))." WIB";
    }

    //Set relation with Kostumer
    public function kostumer(){
        return $this->belongsTo('App\Kostumer', 'kostumer_id');
    }
    //Set relation with Toko
    public function toko(){
        return $this->belongsTo('App\Toko', 'toko_id');
    }

    //Set relation with PenjualanItem
    public function penjualanItem(){
        return $this->hasMany('App\PenjualanItem', 'penjualan_id');
    }
    //Set relation with PenjualanBayar
    public function penjualanBayar(){
        return $this->hasMany('App\penjualanBayar', 'penjualan_id');
    }
}
