<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deuda extends Model
{
    protected $table = 'deudas';
    protected $fillable = [
        'idArriendo',
        'tipo',
        'titulo', 
        'fechaCompromiso', 
        'fechaPago',
        'cantidadDiasRetraso'
    ];

    public function arriendo() {
        return $this->hasOne('App\Arriendo', 'id', 'idArriendo');
    }

    public function pagos()
    {
        return $this->hasMany('App\PagoDeuda', 'idDeuda', 'id');
    }

}
