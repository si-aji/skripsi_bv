<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kostumer extends Model
{
    protected $table = 'tbl_kostumer';

    protected $fillable = [
        "kostumer_nama", "kostumer_kontak", "kostumer_detail",
    ];

    //Set relation with Penjualan
    public function penjualan(){
        return $this->hasMany('App\Penjualan', 'kostumer_id');
    }
}
