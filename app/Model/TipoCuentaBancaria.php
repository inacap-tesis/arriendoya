<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCuentaBancaria extends Model
{
    protected $table = 'tipos_cuenta_bancaria';
    protected $fillable = ['nombre'];
}
