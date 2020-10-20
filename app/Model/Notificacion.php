<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $fillable = ['rutUsuario', 'idCategoria', 'idReferencia', 'estado', 'mensaje'];
}
