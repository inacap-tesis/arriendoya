<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table = 'provincias';
    protected $fillable = [
        'idRegion',
        'nombre'
    ];

    public function region() {
        return $this->belongsTo('App\Region', 'id', 'idRegion');
    }

    public function comunas()
    {
        return $this->hasMany('App\Comuna', 'idProvincia', 'id');
    }

}
