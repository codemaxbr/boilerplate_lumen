<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Uuid;

    protected $casts = [
        'status' => 'bool',
    ];

    protected $fillable = [
        'company',
        'uuid',
        'domain',
        'alias',
        'logo',
        'ref',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_accounts', 'account_id', 'user_id')
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
