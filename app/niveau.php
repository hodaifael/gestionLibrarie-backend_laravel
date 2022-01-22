<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class niveau extends Model
{
    public $timestamps = false;
    protected $fillable = ['nomNiveau','numNiveau','user'];
}
