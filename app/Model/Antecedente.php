<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antecedente extends Model
{
    protected $table = 'antecedentes';
    protected $fillable = ['rutUsuario', 'titulo', 'urlDocumento'];

    public function usuario()
    {
        return $this->belongsTo('App\Usuario', 'rutUsuario', 'rut');
    }

}
