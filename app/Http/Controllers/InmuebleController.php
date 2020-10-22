<?php

namespace App\Http\Controllers;

use App\Inmueble;
use App\Anuncio;
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
        $rut = Auth::user()->rut;
        return Inmueble::where('rutPropietario', $rut)->get();
    }

    public function catalogo() {
        if(Auth::check()) {
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        } else {
            return redirect('/login');
        }
    }

    public function crearAnuncio($id) {
        $inmueble = Inmueble::find($id);
        return view('inmueble.publicar', ['inmueble' => $inmueble]);
    }

    public function publicar(Request $request) {
        $anuncio = Anuncio::find($request->id);
        if(!$anuncio) {
            $anuncio = new Anuncio();
            $anuncio->idInmueble = $request->id;
        }
        $anuncio->condicionesArriendo = $request->condicionesArriendo;
        $anuncio->documentosRequeridos = $request->documentosRequeridos;
        $anuncio->canon = $request->canon;
        $anuncio->fechaActivacion = Now();
        $anuncio->estado = true;
        if($anuncio->save()) {
            $inmueble = Inmueble::find($request->id);
            $inmueble->idEstado = 2;
            if($inmueble->save()) {
                return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
            }
        }
        return 'error';
    }

    public function quitarPublicacion($id) {
        $anuncio = Anuncio::find($id);
        $anuncio->estado = false;
        if($anuncio->save()) {
            $inmueble = Inmueble::find($id);
            $inmueble->idEstado = 1;
            if($inmueble->save()) {
                return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
            }
        }
        return 'error';
    }

    public function activar($id) {
        $inmueble = Inmueble::find($id);
        $inmueble->idEstado = 1;
        if($inmueble->save()) {
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        }
        return 'error';
    }

    public function desactivar($id) {
        $inmueble = Inmueble::find($id);
        $inmueble->idEstado = 3;
        if($inmueble->save()) {
            return view('inmueble.catalogo', ['inmuebles'=> $this->misInmuebles()]);
        }
        return 'error';
    }

    public function formularioModificar($id) {
        $inmueble = Inmueble::find($id);
        return view('inmueble.modificar', [
            'regiones' => Region::all(),
            'provincias' => Provincia::all(),
            'comunas' => Comuna::all(),
            'tipos_inmueble' => TipoInmueble::all(),
            'inmueble'=> $inmueble
            ]);
    }

    public function modificar(Request $request) {

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
        $inmueble->idEstado = 1;
        $inmueble->idComuna = $request->comuna;
        $inmueble->rutPropietario = Auth::user()->rut;
        $inmueble->poblacionDireccion = $request->poblacionDireccion;
        $inmueble->calleDireccion = $request->calleDireccion;
        $inmueble->numeroDireccion = $request->numeroDireccion;
        $inmueble->condominioDireccion = $request->condominioDireccion;
        $inmueble->numeroDepartamentoDireccion = $request->numeroDepartamentoDireccion;
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
