<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Anuncio;
use App\TipoInmueble;
use App\Region;
use App\Provincia;
use App\Comuna;
use App\Inmueble;
use App\Arriendo;

class CatalogoController extends Controller
{

    public function cargar() {
        
        if(Auth::check()) {
            $anuncios = Anuncio::whereNotIn('idInmueble', Inmueble::where('rutPropietario', Auth::user()->rut)->get('id'))->get();
            $inmuebles = count(Inmueble::where([['rutPropietario', '=', Auth::user()->rut], ['idEstado', '<>', 3]])->get());
            $arriendos = count(Arriendo::where([['rutInquilino', '=', Auth::user()->rut], ['estado', '=', true]])->get());
        } else {
            $anuncios = Anuncio::all();
            $inmuebles = 0;
            $arriendos = 0;
        }

        return view('anuncio.catalogo', [
            'anuncios' => $anuncios,
            'tipos' => CatalogoController::consultarTiposInmueble(),
            'regiones' => CatalogoController::consultarRegiones(),
            'precios' => CatalogoController::consultarPrecios(),
            'fechas' => CatalogoController::consultarPeriodosPublicacion(),
            'inmuebles' => $inmuebles,
            'arriendos' => $arriendos
            ]);
    }

    private static $tipos = null;
    public static function consultarTiposInmueble() {
        if(!self::$tipos) {
            self::$tipos = TipoInmueble::all();
        }
        return self::$tipos;
    }

    private static $regiones = null;
    public static function consultarRegiones() {
        if(!self::$regiones) {
            self::$regiones = Region::all();
        }
        return self::$regiones;
    }

    private static $provincias = null;
    public static function consultarProvincias() {
        if(!self::$provincias) {
            self::$provincias = Provincia::all();
        }
        return self::$provincias;
    }

    private static $precios = null;
    public static function consultarPrecios() {
        if(!self::$precios) {
            $lista = collect([
                ['id' => '1', 'nombre' => '$ 0'],
                ['id' => '2', 'nombre' => '$ 100.000'],
                ['id' => '3', 'nombre' => '$ 200.000'],
                ['id' => '4', 'nombre' => '$ 300.000'],
                ['id' => '5', 'nombre' => '$ 400.000'],
                ['id' => '6', 'nombre' => '$ 500.000'],
                ['id' => '7', 'nombre' => '$ 600.000'],
                ['id' => '8', 'nombre' => '$ 700.000'],
                ['id' => '9', 'nombre' => '$ 800.000'],
                ['id' => '10', 'nombre' => '$ 900.000'],
                ['id' => '11', 'nombre' => '$ 1.000.000'],
                ['id' => '12', 'nombre' => '$ 1.200.000'],
                ['id' => '13', 'nombre' => '$ 1.400.000'],
                ['id' => '14', 'nombre' => '$ 1.600.000'],
                ['id' => '15', 'nombre' => '$ 1.800.000'],
                ['id' => '16', 'nombre' => '$ 2.000.000'],
                ['id' => '17', 'nombre' => '$ 3.000.000'],
                ['id' => '18', 'nombre' => '$ 4.000.000'],
            ]);
            self::$precios = $lista->pluck('nombre', 'id');
        }
        return self::$precios;
    }

    private static $periodosPublicacion = null;
    public static function consultarPeriodosPublicacion() {
        if(!self::$periodosPublicacion) {
            $lista = collect([
                ['id' => '1', 'nombre' => 'Hoy'],
                ['id' => '2', 'nombre' => 'Esta semana'],
                ['id' => '3', 'nombre' => 'Este mes'],
                ['id' => '4', 'nombre' => 'Últimos tres meses'],
                ['id' => '5', 'nombre' => 'Más de tres meses']
            ]);
            self::$periodosPublicacion = $lista->pluck('nombre', 'id');
        }
        return self::$periodosPublicacion;
    }

    public function seleccionarRegion(Request $request) {
        return CatalogoController::consultarRegiones()->find($request->id)->provincias;
    }

    public function seleccionarProvincia(Request $request) {
        return CatalogoController::consultarProvincias()->find($request->id)->comunas;
    }

    public function filtrar(Request $request) {
        
    }

    public function eliminarFiltros() {
        $this->cargar();
    }

    public function ordenarPrecioMayor() {
        
    }

    public function ordenarPrecioMenor() {
        
    }

    public function ordenarFechaMayor() {
        
    }

    public function ordenarFechaMenor() {
        
    }

}