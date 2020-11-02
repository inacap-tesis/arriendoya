<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Region;
use App\Provincia;
use App\Comuna;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{

    public function cambiarClave(Request $request) {
        return Auth::guard()->getTokenForRequest();
        //return view('auth.passwords.reset');
    }

    public function create()
    {
        return view('usuario.registrar', [
            'regiones' => Region::all(),
            'provincias' => Provincia::all(),
            'comunas' => Comuna::all()
        ]);
    }

    public function store(Request $request)
    {
        $persona = new Persona();
        $persona->rut = $request->rut;
        $persona->primerNombre = $request->primerNombre;
        $persona->segundoNombre = $request->segundoNombre ? $request->segundoNombre: '';
        $persona->primerApellido = $request->primerApellido;
        $persona->segundoApellido = $request->segundoApellido ? $request->segundoApellido : '';
        $persona->fechaNacimiento = $request->fechaNacimiento;
        $persona->correo = $request->correo;
        $persona->telefono = $request->telefono;
        $personaResult = $persona->save();
        $usuarioResult = 0;
        if(isset($personaResult) && $personaResult > 0) {
            $usuario = new Usuario();
            $usuario->rutPersona = $request->rut;
            $usuario->clave = $request->clave;
            $usuario->urlFoto = '';
            $usuarioResult = $usuario->save();
        }
        return isset($usuarioResult) && $usuarioResult > 0 ? 'OK' : 'No guardó registro';
    }

}
