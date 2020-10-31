<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{

    protected $table = 'cuentas_bancarias';
    protected $keyType = 'string';
    protected $primaryKey = 'rutUsuario';
    protected $fillable = [
        'numero',
        'idBanco',
        'idTipo'
    ];

    public function banco() {
        return $this->hasOne('App\Banco', 'id', 'idBanco');
    }

    public function tipoCuenta() {
        return $this->hasOne('App\TipoCuentaBancaria', 'id', 'idTipo');
    }

}
