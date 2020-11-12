<?php

namespace App\Http\Controllers;

use App\Antecedente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntecedenteController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function listar($rut = null) {
        if($rut) {
            return Antecedente::where('rutUsuario', '=', $rut)->get();
        } else {
            return view('antecedente.listar', [
                'antecedentes' => Auth::user()->antecedentes
            ]);
        }
        
    }

    public function configurar($id = null) {
        $antecedente = Antecedente::find($id);
        return view('antecedente.configurar', [
            'antecedente' => $antecedente
        ]);
    }

    public function registrar(Request $request) {
        $validator = \Validator::make($request->all(), [
            'titulo' => 'required',
            'documento' => 'required|file|max:1024|mimes:pdf'
        ], [
            'titulo.required' => 'El título es requerido.',
            'documento.required' => 'El documento es requerido',
            'documento.max' => 'El documento debe pesar menos de 1024 kilobytes.',
            'documento.mimes' => 'Sólamente se permiten documentos PDF.'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $antecedente = new Antecedente();
        $antecedente->rutUsuario = Auth::user()->rut;
        $antecedente->titulo = $request->titulo;
        $antecedente->urlDocumento = $request->file('documento')->store('antecedentes');
        $antecedente->save();
        return redirect('/antecedentes');
    }

    public function eliminar(Request $request) {
        $antecedente = Antecedente::find($request->id);
        \Storage::delete($antecedente->urlDocumento);
        $antecedente->delete();
        return redirect('/antecedentes');
    }

    public function descargar($id) {
        $antecedente = Antecedente::find($id);
        $url = base_path().'/storage/app/public/'.$antecedente->urlDocumento;
        $extension = pathinfo(storage_path($url), PATHINFO_EXTENSION);
        $headers = array('Content-Type: application/pdf');
        return \Response::download($url, $antecedente->titulo.'.'.$extension, $headers);
    }

}
