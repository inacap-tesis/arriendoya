<?php

namespace App\Http\Controllers;

use App\CuentaBancaria;
use App\Banco;
use App\TipoCuentaBancaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentaBancariaController extends Controller
{

    public function formularioConfigurar() {

        $bancos = Banco::all();
        $tipos = TipoCuentaBancaria::all();
        $cuenta = CuentaBancaria::find(Auth::user()->rut);
        //$cuenta = CuentaBancaria::where('rutUsuario', '=', Auth::user()->rut)->first();

        return view('cuenta.configurar', [
            'bancos' => $bancos,
            'tipos' => $tipos,
            'cuenta' => $cuenta
        ]);
    }

    public function configurar(Request $request) {
        $cuenta = CuentaBancaria::where('rutUsuario', '=', Auth::user()->rut)->first();
        if(!$cuenta) {
            $cuenta = new CuentaBancaria();
            $cuenta->rutUsuario = Auth::user()->rut;
        }
        $cuenta->numero = $request->numero;
        $cuenta->idBanco = $request->banco;
        $cuenta->idTipo = $request->tipo;
        $cuenta->save();
        return back();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function show(CuentaBancaria $cuentaBancaria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function edit(CuentaBancaria $cuentaBancaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CuentaBancaria $cuentaBancaria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(CuentaBancaria $cuentaBancaria)
    {
        //
    }
}
