<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Arriendo extends Model
{
    protected $table = 'arriendos';
    protected $fillable = [
        'idInmueble',
        'fechaInicio',
        'fechaTerminoPropuesta', 
        'canon', 
        'garantia',
        'rutInquilino',
        'diaPago',
        'estado',
        'subarriendo',
        'mesesModificacionPeriodicidad',
        'urlContrato',
        'numeroRenovacion', 
        'fechaTerminoReal'
    ];

    public function inmueble() {
        return $this->belongsTo('App\Inmueble', 'idInmueble', 'id');
    }

    public function inquilino() {
        return $this->belongsTo('App\Usuario', 'rutInquilino', 'rut');
    }

    public function deudas()
    {
        return $this->hasMany('App\Deuda', 'idArriendo', 'id');
    }
}
