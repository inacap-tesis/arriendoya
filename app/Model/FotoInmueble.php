<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoInmueble extends Model
{
    protected $table = 'fotos_inmueble';
    protected $fillable = [
        'idInmueble',
        'urlFoto'
    ];

    public function inmueble() {
        return $this->belongsTo('App\Inmueble', 'id', 'idInmueble');
    }

}
