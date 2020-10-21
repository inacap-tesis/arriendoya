<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anuncio;

class CatalogoController extends Controller
{
    public function load() {
        $anuncios = Anuncio::all();
        return view('anuncio.catalogo', ['anuncios' => $anuncios]);
    }
}
