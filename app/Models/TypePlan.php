<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePlan extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug'];
}
