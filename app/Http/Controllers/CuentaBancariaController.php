<?php

namespace App\Http\Controllers;

use App\CuentaBancaria;
use App\Banco;
use App\TipoCuentaBancaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuentaBancariaController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function configurar() {

        $bancos = Banco::all();
        $tipos = TipoCuentaBancaria::all();
        $cuenta = CuentaBancaria::find(Auth::user()->rut);

        return view('cuenta.configurar', [
            'bancos' => $bancos,
            'tipos' => $tipos,
            'cuenta' => $cuenta
        ]);
    }

    public function registrar(Request $request) {
        $cuenta = new CuentaBancaria();
        $cuenta->rutUsuario = Auth::user()->rut;
        $cuenta->numero = $request->numero;
        $cuenta->idBanco = $request->banco;
        $cuenta->idTipo = $request->tipo;
        $cuenta->save();
        return redirect('/');
    }

    public function modificar(Request $request) {
        $cuenta = CuentaBancaria::where('rutUsuario', '=', Auth::user()->rut)->first();
        $cuenta->numero = $request->numero;
        $cuenta->idBanco = $request->banco;
        $cuenta->idTipo = $request->tipo;
        $cuenta->save();
        return redirect('/');
    }

}
