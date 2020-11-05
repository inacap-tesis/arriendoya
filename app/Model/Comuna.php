<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    protected $table = 'comunas';
    protected $fillable = [
        'idProvincia',
        'nombre'
    ];

    public function provincia() {
        return $this->belongsTo('App\Provincia', 'idProvincia', 'id');
    }

}
