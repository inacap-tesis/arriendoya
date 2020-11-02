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

    public function tipo() {
        return $this->belongsTo('App\TipoInmueble', 'idTipoInmueble', 'id');
    }

    public function estado() {
        return $this->belongsTo('App\EstadoInmueble', 'idEstado', 'id');
    }

    public function comuna() {
        return $this->belongsTo('App\Comuna', 'idComuna', 'id');
    }

    public function anuncio() {
        return $this->hasOne('App\Anuncio', 'idInmueble', 'id');
    }

    public function propietario() {
        return $this->belongsTo('App\Usuario', 'rutPropietario', 'rut');
    }

    public function pagos()
    {
        return $this->hasMany('App\FotoInmueble', 'idInmueble', 'id');
    }

    public function arriendos()
    {
        return $this->hasMany('App\Arriendo', 'idInmueble', 'id');
    }

    public function fotos()
    {
        return $this->hasMany('App\FotoInmueble', 'idInmueble', 'id');
    }

    public function calificaciones() {
        return $this->hasManyThrough(
            'App\Calificacion',
            'App\Arriendo',
            'idInmueble',
            'idArriendo',
            'id',
            'idInmueble'
        );
    }

}
