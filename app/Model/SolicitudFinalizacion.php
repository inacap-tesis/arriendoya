<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudFinalizacion extends Model
{
    protected $table = 'solicitudes_finalizacion';
    protected $fillable = [
        'idArriendo',
        'rutEmisor',
        'rutReceptor',
        'fechaPropuesta',
        'respuesta'
    ];

    public function arriendo() {
        return $this->belongsTo('App\Arriendo', 'idArriendo', 'id');
    }

    public function emisor() {
        return $this->belongsTo('App\Usuario', 'rutEmisor', 'rut');
    }

    public function receptor() {
        return $this->belongsTo('App\Usuario', 'rutReceptor', 'rut');
    }
}
