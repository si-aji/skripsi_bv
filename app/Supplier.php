<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'tbl_supplier';

    protected $fillable = [
        "supplier_nama", "supplier_kontak", "supplier_detail", "supplier_status"
    ];

    //Set relation with pembelian
    public function pembelian(){
        return $this->hasMany('App\Pembelian', 'supplier_id');
    }
}
