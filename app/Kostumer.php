<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kostumer extends Model
{
    protected $table = 'tbl_kostumer';

    protected $fillable = [
        "kostumer_nama", "kostumer_kontak", "kostumer_detail",
    ];
}
