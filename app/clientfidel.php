<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientfidel extends Model
{
    public $timestamps = false;
    protected $fillable = ['num','name', 'cin','point','user','date','heure'];
}
