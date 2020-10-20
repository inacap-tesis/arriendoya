<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriaNotificacion extends Model
{
    protected $table = 'categorias_notificacion';
    protected $fillable = ['nombre'];
}
