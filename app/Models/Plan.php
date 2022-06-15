<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'uuid',
        'name',
        'status',
        'recurrence',
        'req_domain',
        'tax',
        'price',
        'trial',
        'cycle',
        'limit',
        'module_id',
        'config',
        'pricing',
        'grid_id',
        'account_id'
    ];

    public function grid()
    {
        return $this->belongsTo(Grid::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
