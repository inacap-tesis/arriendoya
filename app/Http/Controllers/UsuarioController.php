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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuario.registrar', [
            'regiones' => Region::all(),
            'provincias' => Provincia::all(),
            'comunas' => Comuna::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }
}
