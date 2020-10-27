<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    protected $table = 'anuncios';
    protected $primaryKey = 'idInmueble';
    protected $fillable = [
        'idInmueble',
        'condicionesArriendo',
        'documentosRequeridos', 
        'canon', 
        'fechaActivacion',
        'estado'
    ];

    public function inmueble() {
        return $this->belongsTo('App\Inmueble', 'idInmueble', 'id');
    }

    public function interesados() {
        return $this->belongsToMany('App\Usuario', 'interes_usuario_anuncio', 'idAnuncio', 'rutUsuario');
    }

}
