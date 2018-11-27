<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'tbl_pembelian';

    protected $fillable = [
        "supplier_id", "pembelian_invoice", "pembelian_tgl", "pembelian_detail",
    ];

    public function getCreatedAtAttribute($created_at){
        return date("M", strtotime($created_at))." ".date("d", strtotime($created_at)).", ".date("Y", strtotime($created_at))." / ".date("H", strtotime($created_at)).":".date("i", strtotime($created_at)).":".date("s", strtotime($created_at))." WIB";
    }
    public function getUpdatedAtAttribute($updated_at){
        return date("M", strtotime($updated_at))." ".date("d", strtotime($updated_at)).", ".date("Y", strtotime($updated_at))." / ".date("H", strtotime($updated_at)).":".date("i", strtotime($updated_at)).":".date("s", strtotime($updated_at))." WIB";
    }

    //Set relation with Kostumer
    public function supplier(){
        return $this->belongsTo('App\Supplier', 'supplier_id');
    }
    //Set relation with pembelianItem
    public function pembelianItem(){
        return $this->hasMany('App\PembelianItem', 'pembelian_id');
    }
    //Set relation with pembelianBayar
    public function pembelianBayar(){
        return $this->hasMany('App\PembelianBayar', 'pembelian_id');
    }
}
