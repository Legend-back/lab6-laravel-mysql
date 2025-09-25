<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $table = 'dogs';
    public $timestamps = false;
    protected $fillable = ['nombre'];
}