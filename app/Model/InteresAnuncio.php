<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InteresAnuncio extends Model
{
    protected $table = 'interes_usuario_anuncio';
    protected $fillable = [
        'idAnuncio ',
        'rutUsuario ', 
        'candidato'
    ];

}
