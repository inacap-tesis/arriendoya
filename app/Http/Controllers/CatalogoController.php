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
use DateTime;

class CatalogoController extends Controller
{

    private function consultarAnuncios() {
        if(Auth::check()) {
            $anuncios = Anuncio::whereNotIn('idInmueble', Inmueble::where('rutPropietario', Auth::user()->rut)->get('id'))->get();
        } else {
            $anuncios = Anuncio::all();
        }
        return $anuncios->where('estado', '=', true);
    }

    public function cargar() {
        
        if(Auth::check()) {
            $inmuebles = Auth::user()->inmuebles->count();
            $arriendos = Auth::user()->arriendos->where('estado', true)->count();
            $arriendos += Auth::user()->arriendos->where('estado', false)->where('calificacion.notaAlArriendo', 0)->count();
        } else {
            $inmuebles = 0;
            $arriendos = 0;
        }

        return view('catalogo.inicio', [
            'anuncios' => $this->consultarAnuncios(),
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

    private static $comunas = null;
    public static function consultarComunas() {
        if(!self::$comunas) {
            self::$comunas = Comuna::all();
        }
        return self::$comunas;
    }

    private static $precios = null;
    public static function consultarPrecios() {
        if(!self::$precios) {
            $lista = collect([
                ['id' => '100000', 'nombre' => '$ 100.000'],
                ['id' => '200000', 'nombre' => '$ 200.000'],
                ['id' => '300000', 'nombre' => '$ 300.000'],
                ['id' => '400000', 'nombre' => '$ 400.000'],
                ['id' => '500000', 'nombre' => '$ 500.000'],
                ['id' => '600000', 'nombre' => '$ 600.000'],
                ['id' => '700000', 'nombre' => '$ 700.000'],
                ['id' => '800000', 'nombre' => '$ 800.000'],
                ['id' => '900000', 'nombre' => '$ 900.000'],
                ['id' => '1000000', 'nombre' => '$ 1.000.000'],
                ['id' => '1200000', 'nombre' => '$ 1.200.000'],
                ['id' => '1400000', 'nombre' => '$ 1.400.000'],
                ['id' => '1600000', 'nombre' => '$ 1.600.000'],
                ['id' => '1800000', 'nombre' => '$ 1.800.000'],
                ['id' => '2000000', 'nombre' => '$ 2.000.000'],
                ['id' => '3000000', 'nombre' => '$ 3.000.000'],
                ['id' => '4000000', 'nombre' => '$ 4.000.000'],
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
                ['id' => '4', 'nombre' => 'Últimos tres meses']
            ]);
            self::$periodosPublicacion = $lista->pluck('nombre', 'id');
        }
        return self::$periodosPublicacion;
    }

    public static function consultarMes($id) {
        switch ($id) {
            case 1: return 'ENERO';
            case 2: return 'FEBRERO';
            case 3: return 'MARZO';
            case 4: return 'ABRIL';
            case 5: return 'MAYO';
            case 6: return 'JUNIO';
            case 7: return 'JULIO';
            case 8: return 'AGOSTO';
            case 9: return 'SEPTIEMBRE';
            case 10: return 'OCTUBRE';
            case 11: return 'NOVIEMBRE';
            case 12: return 'DICIEMBRE';
            default: return '';
        }
    }

    public function seleccionarRegion(Request $request) {
        return CatalogoController::consultarRegiones()->find($request->id)->provincias;
    }

    public function seleccionarProvincia(Request $request) {
        return CatalogoController::consultarProvincias()->find($request->id)->comunas;
    }

    public function filtrar(Request $request) {

        $anuncios = $this->consultarAnuncios();

        if($request->tipoOrden) {
            $anuncios = $this->ordenar($anuncios, $request->tipoOrden);
        }

        $tipo = (int)$request->tipo;
        $region = (int)$request->region;
        $provincia = (int)$request->provincia;
        $comuna = (int)$request->comuna;
        $min = (int)$request->min;
        $max = (int)$request->max;
        $fecha = (int)$request->fecha;

        if($tipo > 0) {
            $anuncios = $this->anunciosTipo($anuncios, $tipo);
        }
        if($region > 0 && $provincia == 0) {
            $anuncios = $this->anunciosRegion($anuncios, $region);
        }
        if($provincia > 0 && $comuna == 0) {
            $anuncios = $this->anunciosProvincia($anuncios, $provincia);
        }
        if($comuna > 0) {
            $anuncios = $this->anunciosComuna($anuncios, $comuna);
        }
        if($min > 0) {
            $anuncios = $this->anunciosPrecioMenor($anuncios, $min);
        }
        if($max > 0) {
            $anuncios = $this->anunciosPrecioMayor($anuncios, $max);
        }
        if($fecha > 0) {
            $anuncios = $this->anunciosPeriodo($anuncios, $fecha);
        }

        $lista = [];
        foreach($anuncios as $anuncio) {
            $tipo = $anuncio->inmueble->tipo;
            $region = $anuncio->inmueble->comuna->provincia->region;
            array_push($lista, $anuncio);
        }
        $anuncios = $lista;

        $response = '';
        foreach($anuncios as $anuncio) {
            $fecha = new DateTime($anuncio->fechaPublicacion);
            $response .= view('catalogo.item', [
                'titulo' => $anuncio->inmueble->tipo->nombre.' en '.$anuncio->inmueble->calleDireccion.' '.$anuncio->inmueble->numeroDireccion,
                'canon' => '$ '.number_format($anuncio->canon, 0, '.', '.'),
                'caracteristicas' => $anuncio->inmueble->caracteristicas,
                'foto' => $anuncio->inmueble->fotos->count() > 0 ? $anuncio->inmueble->fotos->first()->urlFoto : null,
                'id' => $anuncio->idInmueble,
                'nota' => 3,
                'fecha' => $fecha->format('d-m-Y')
                ])->render();
        }
        return response()->json([ 'view' => $response ]);
    }

    public function anunciosTipo($anuncios, $tipo) {
        $lista = [];
        foreach($anuncios as $anuncio) {
            if($anuncio->inmueble->idTipoInmueble == $tipo) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function anunciosRegion($anuncios, $region) {
        $lista = [];
        foreach($anuncios as $anuncio) {
            if($anuncio->inmueble->comuna->provincia->idRegion == $region) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function anunciosProvincia($anuncios, $provincia) {
        $lista = [];
        foreach($anuncios as $anuncio) {
            if($anuncio->inmueble->comuna->idProvincia == $provincia) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function anunciosComuna($anuncios, $comuna) {
        $lista = [];
        foreach($anuncios as $anuncio) {
            if($anuncio->inmueble->idComuna == $comuna) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function anunciosPrecioMenor($anuncios, $precioMenor) {
        $lista = [];
        foreach($anuncios as $anuncio) {
            if($anuncio->canon >= $precioMenor) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function anunciosPrecioMayor($anuncios, $precioMayor) {
        $lista = [];
        foreach($anuncios as $anuncio) {
            if($anuncio->canon <= $precioMayor) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function anunciosPeriodo($anuncios, $periodo) {
        switch ($periodo) {
            case 1: 
                $hoy = Now();
                $inicio = new \DateTime($hoy->format('d-m-Y').' 00:00:00');
                $fin = new \DateTime($hoy->format('d-m-Y').' 23:59:59');
            break;
            case 2:
                $semanaActual = (int)Now()->format('W');
                $temp = Now();
                while((int)$temp->format('W') == $semanaActual) {
                    $temp->modify('-1 day');
                }
                $temp->modify('+1 day');
                $inicio = new \DateTime($temp->format('d-m-Y').' 00:00:00');
                $fin = new \DateTime(Now()->format('d-m-Y').' 23:59:59');
            break;
            case 3:
                $temp = Now();
                $inicio = new \DateTime('1-'.$temp->format('m-Y').' 00:00:00');
                $fin = new \DateTime(Now()->format('d-m-Y').' 23:59:59');
            break;
            case 4:
                $temp = Now()->modify('-2 month');
                $inicio = new \DateTime('1-'.$temp->format('m-Y').' 00:00:00');
                $fin = new \DateTime(Now()->format('d-m-Y').' 23:59:59');
            break;
            default: return $anuncios;
        }
        $lista = [];
        foreach($anuncios as $anuncio) {
            $fecha = new \DateTime($anuncio->fechaPublicacion);
            if($fecha >= $inicio && $fecha <= $fin) {
                array_push($lista, $anuncio);
            }
        }
        return $lista;
    }

    public function ordenar($lista, $tipo) {
        if($tipo == 'precio') {
            return $lista->sortBy('canon');
        } else {
            return $lista->sortBy('fechaPublicacion');
        }
    }

}