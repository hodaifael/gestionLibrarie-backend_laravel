<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class benefcommande extends Model
{
    public $timestamps = false;
    protected $fillable = ['numbenef','numcommande'];
}
