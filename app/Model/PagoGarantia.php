<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoGarantia extends Model
{
    protected $table = 'pagos_garantia';
    protected $fillable = [
        'idGarantia',
        'fecha',
        'urlComprobante'
    ];

    public function garantia() {
        return $this->belongsTo('App\Garantia', 'idArriendo', 'idGarantia');
    }

}
