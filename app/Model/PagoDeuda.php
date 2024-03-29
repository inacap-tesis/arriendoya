<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoDeuda extends Model
{
    protected $table = 'pagos_deuda';
    protected $fillable = [
        'idDeuda',
        'fecha',
        'urlComprobante'
    ];

    public function deuda() {
        return $this->belongsTo('App\Deuda', 'id', 'idDeuda');
    }

}
