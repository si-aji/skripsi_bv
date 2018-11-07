<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'tbl_barang';

    protected $fillable = [
        "kategori_id", "barang_kode", "barang_nama", "barang_stokStatus", "barang_stok", "barang_hBeli", "barang_hJual", "barang_detail", "barang_status", "barang_slug"
    ];

    //Set relation with Kategori
    public function kategori(){
        return $this->belongsTo('App\Kategori', 'kategori_id');
    }
    //Set relation with PenjualanDetail
    public function penjualanDetail(){
        return $this->hasMany('App\PenjualanDetail', 'barang_id');
    }
}
