<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function delete() {
        return DB::delete('delete from '.$this->table.' where idAnuncio = '.$this->idAnuncio.' and rutUsuario = "'.$this->rutUsuario.'"');
    }

}
