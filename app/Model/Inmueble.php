<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    protected $table = 'inmuebles';
    protected $fillable = [
        'idTipoInmueble',
        'idEstado',
        'idComuna', 
        'rutPropietario', 
        'poblacionDireccion',
        'calleDireccion',
        'numeroDireccion',
        'condominioDireccion',
        'numeroDepartamentoDireccion',
        'caracteristicas'
    ];
}
