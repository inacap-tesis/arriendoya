<?php

namespace App\Http\Controllers;

use App\Inmueble;
use App\Region;
use App\Provincia;
use App\Comuna;
use App\TipoInmueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InmuebleController extends Controller
{

    public function __construct() {
        //$this->middleware('auth', ['only' => ['misInmuebles']]);
        $this->middleware('auth');
    }

    public function misInmuebles() {
        if(Auth::check()) {
            return view('inmueble.catalogo', ['inmuebles'=> Inmueble::all()]);
        } else {
            return redirect('/login');
        }
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
        return view('inmueble.registrar', [
            'regiones' => Region::all(),
            'provincias' => Provincia::all(),
            'comunas' => Comuna::all(),
            'tipos_inmueble' => TipoInmueble::all()
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
        $inmueble = new Inmueble();
        $inmueble->idTipoInmueble = $request->tipo;
        $inmueble->idComuna = $request->comuna;
        $inmueble->rutPropietario = '24765918-8';
        $inmueble->direccion = $request->direccion;
        $inmueble->caracteristicas = $request->caracteristicas;
        $inmueble->save();
        return $inmueble;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function show(Inmueble $inmueble)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function edit(Inmueble $inmueble)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inmueble $inmueble)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inmueble  $inmueble
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inmueble $inmueble)
    {
        //
    }
}
