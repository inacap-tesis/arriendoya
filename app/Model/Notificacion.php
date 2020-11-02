<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $fillable = [
        'rutUsuario', 
        'idCategoria', 
        'idReferencia', 
        'estado', 
        'mensaje'
    ];

    public function usuario() {
        return $this->belongsTo('App\Usuario', 'rut', 'rutUsuario');
    }

    public function categoria() {
        return $this->belongsTo('App\CategoriaNotificacion', 'id', 'idCategoria');
    }

}
