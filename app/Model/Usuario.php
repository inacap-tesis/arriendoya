<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

class Usuario extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    protected $table = 'usuarios';
    protected $keyType = 'string';
    protected $primaryKey = 'rut';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut', 
        'primerNombre', 
        'segundoNombre', 
        'primerApellido', 
        'segundoApellido', 
        'fechaNacimiento', 
        'email',
        'telefono',
        'password',
        'urlFoto'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cuentaBancaria() {
        return $this->hasOne('App\CuentaBancaria', 'rutUsuario', 'rut');
    }

    public function antecedentes()
    {
        return $this->hasMany('App\Antecedente', 'rutUsuario', 'rut');
    }

    public function notificaciones()
    {
        return $this->hasMany('App\Notificacion', 'rutUsuario', 'rut');
    }

    public function inmuebles()
    {
        return $this->hasMany('App\Inmueble', 'rutPropietario', 'rut')->orderBy('id','DESC');
    }

    public function arriendos()
    {
        return $this->hasMany('App\Arriendo', 'rutInquilino', 'rut')->orderBy('fechaTerminoReal','DESC');
    }

    public function solicitudesFinzalizacionEnviadas()
    {
        return $this->hasMany('App\SolicitudFinalizacion', 'rutEmisor', 'rut');
    }

    public function solicitudesFinzalizacionRecibidas()
    {
        return $this->hasMany('App\SolicitudFinalizacion', 'rutReceptor', 'rut');
    }

    public function interesAnuncios() {
        return $this->belongsToMany('App\Anuncio', 'interes_usuario_anuncio', 'rutUsuario', 'idAnuncio');
    }

    public function calificacionesComoPropietario() {
        return $this->hasManyThrough(
            'App\Arriendo',
            'App\Inmueble',
            'rutPropietario',
            'idInmueble',
            'rut',
            'id'
        )->join('calificaciones','arriendos.idInmueble','=','calificaciones.idArriendo')->select('calificaciones.*');
    }

    public function calificacionesComoInquilino() {
        return $this->hasManyThrough(
            'App\Calificacion',
            'App\Arriendo',
            'rutInquilino',
            'idArriendo',
            'rut',
            'idInmueble'
        );
    }

}

