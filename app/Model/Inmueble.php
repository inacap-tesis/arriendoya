<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = 'inmuebles';
    protected $fillable = [
        'idTipoInmueble', 
        'idComuna', 
        'rutPropietario', 
        'direccion', 
        'caracteristicas'
    ];
}
