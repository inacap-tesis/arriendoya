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
        'rutInquilino',
        'diaPago',
        'estado',
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

    public function garantia() {
        return $this->belongsTo('App\Garantia', 'id', 'idArriendo');
    }

    public function calificacion() {
        return $this->belongsTo('App\Calificacion', 'id', 'idArriendo');
    }

    public function deudas()
    {
        return $this->hasMany('App\Deuda', 'idArriendo', 'id');
    }

    public function solicitudesFinalizacion()
    {
        return $this->hasMany('App\SolicitudFinalizacion', 'idArriendo', 'id');
    }

}
