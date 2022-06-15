<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grid extends Model
{
    protected $fillable = [
        'name',
        'type_plan_id',
        'account_id'
    ];

    public function type_plan()
    {
        return $this->belongsTo(TypePlan::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }
}
