<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    protected $table = 'deudas';
    protected $fillable = [
        'idArriendo',
        'titulo', 
        'fechaCompromiso', 
        'estado'
    ];

    public function arriendo() {
        return $this->belongsTo('App\Arriendo', 'id', 'idArriendo');
    }

    public function pagos()
    {
        return $this->hasMany('App\PagoDeuda', 'idDeuda', 'id');
    }

}
