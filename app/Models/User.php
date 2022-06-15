<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property boolean|null $photo
 * @property bool|null $confirmed
 * @property bool|null $is_reseller
 * @property bool|null $is_owner
 * @property string|null $password_token
 * @property Carbon|null $password_token_expires
 * @property int|null $account_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 * @method static whereEmail($email)
 */

class User extends Eloquent
{
    protected $guard_name = 'api';

    protected $casts = [
        'confirmed' => 'bool',
        'is_reseller' => 'bool',
        'is_owner' => 'bool',
        'account_id' => 'int'
    ];

    protected $dates = [
        'password_token_expires'
    ];

    protected $hidden = [
        'password',
        'auth_token',
        'auth_token_expires',
        'deleted_at',
        'permissions',
        'roles'
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'confirmed',
        'is_reseller',
        'is_owner',
        'password_token',
        'password_token_expires',
        'account_id'
    ];

    protected $with = ['accounts'];

    public function setPasswordAttribute($senha)
    {
        $this->attributes['password'] = Hash::make($senha);
    }

    public function alterarSenha($nova_senha)
    {
        $this->password = $nova_senha;
        $this->auth_token = null;
        $this->auth_token_expires = null;
        $this->save();
    }

    public function confirmar()
    {
        $this->auth_token = null;
        $this->auth_token_expires = null;
        $this->confirmed = true;
        $this->save();
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'users_accounts', 'user_id', 'account_id')
            ->as('property')
            ->withPivot('owner')
            ->withTimestamps();
    }
}
