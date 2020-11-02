<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescuentoDevolucionGarantia extends Model
{
    protected $table = 'descuentos_devolucion_garantia';
    protected $fillable = [
        'idDevolucionGarantia',
        'monto',
        'motivo'
    ];

    public function devolucionGarantia() {
        return $this->belongsTo('App\DevolucionGarantia', 'idGarantia', 'idDevolucionGarantia');
    }

}
