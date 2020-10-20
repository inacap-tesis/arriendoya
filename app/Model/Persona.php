<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'rut';
    protected $keyType = 'string';
    protected $fillable = [
        'rut', 
        'primerNombre', 
        'segundoNombre', 
        'primerApellido', 
        'segundoApellido', 
        'fechaNacimiento', 
        'telefono'
    ];
}
