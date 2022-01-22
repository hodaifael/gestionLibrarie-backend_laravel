<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    public $timestamps = false;
    protected $fillable = ['codep','name', 'pu', 'pht','type','qt','img'];
}
