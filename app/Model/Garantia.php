<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $table = 'garantias';
    protected $primaryKey = 'idArriendo';
    public $timestamps = false;
    protected $fillable = [
        'idArriendo',
        'estado',
        'monto'
    ];

    public function arriendo() {
        return $this->belongsTo('App\Arriendo', 'id', 'idArriendo');
    }

    public function devolucionGarantia() {
        return $this->hasOne('App\DevolucionGarantia', 'idGarantia', 'idArriendo');
    }

    public function pagos()
    {
        return $this->hasMany('App\PagoGarantia', 'idGarantia', 'idArriendo');
    }

}
