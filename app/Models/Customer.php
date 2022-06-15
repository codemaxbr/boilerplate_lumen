<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Customer extends Model
{
    use Uuid;

    public static $permissions = [
        'customer.create' 	=> 'Criar um novo cliente',
        'customer.edit' 	=> 'Alterar dados de clientes',
        'customer.delete' 	=> 'Excluir um cliente',
        'customer.login' 	=> 'Simular acesso de clientes',
        'customer.message' 	=> 'Enviar mensagem para clientes',
    ];

    protected $casts = [
        'confirmed' => 'bool'
    ];

    protected $fillable = [
        'name',
        'uuid',
        'company',
        'type',
        'cpf_cnpj',
        'photo',
        'email',
        'password',
        'auth_token',
        'auth_token_expires',
        'email_nfe',
        'phone',
        'birthdate',
        'confirmed',
        'account_id'
    ];

    protected $hidden = [
        'pivot',
        'password',
        'auth_token',
        'auth_token_expires',
    ];

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

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
