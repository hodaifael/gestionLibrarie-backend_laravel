<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khadamat extends Model
{
    public $timestamps = false;
    protected $fillable = ['type','typerecharge', 'montant','user','time'];
}
