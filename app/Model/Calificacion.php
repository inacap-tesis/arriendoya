<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';
    protected $primaryKey = 'idArriendo';
    protected $fillable = [
        'idArriendo',
        'notaAlArriendo',
        'notaAlInquilino', 
        'comentarioAlArriendo',
        'comentarioAlInquilino'
    ];

    public function arriendo() {
        return $this->belongsTo('App\Arriendo', 'idArriendo', 'id');
    }
}
