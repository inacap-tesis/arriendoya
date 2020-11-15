<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DevolucionGarantia extends Model
{
    protected $table = 'devoluciones_garantia';
    protected $primaryKey = 'idGarantia';
    protected $fillable = [
        'idGarantia',
        'monto',
        'fecha', 
        'urlComprobante'
    ];

    public function garantia() {
        return $this->belongsTo('App\Garantia', 'idGarantia', 'idArriendo');
    }

    public function descuentos()
    {
        return $this->hasMany('App\DescuentoDevolucionGarantia', 'idDevolucionGarantia', 'idGarantia');
    }

}
