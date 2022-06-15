<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'product_id',
        'product_type',
        'subscription_id',
        'customer_id',
        'due',
        'total',
        'activated_at',
        'in_trial',
        'recurrence',
        'status',
        'domain',
        'user',
        'password',
        'cancelled_at',
        'account_id',
        'invoice_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subscription()
    {
        return $this->belongsTo(self::class);
    }

    public function product()
    {
        return $this->morphTo();
    }
}
