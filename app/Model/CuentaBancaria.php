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

}
