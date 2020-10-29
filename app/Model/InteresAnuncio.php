<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InteresAnuncio extends Model
{
    protected $table = 'interes_usuario_anuncio';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = [
        'idAnuncio ',
        'rutUsuario ', 
        'candidato'
    ];

    public function anuncio()
    {
        return $this->belongsTo('App\Anuncio', 'idAnuncio');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'rutUsuario');
    }

}
