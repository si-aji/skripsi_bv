<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apriori extends Model
{
    protected $table = 'tbl_apriori';

    protected $fillable = [
        "min_support", "min_confidence"
    ];
}
