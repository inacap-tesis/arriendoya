<?php

use Illuminate\Database\Seeder;
use App\Arriendo;
use App\Http\Controllers\DeudaController;

class ArriendoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('arriendos')->delete();
        DB::table('arriendos')->insert([
            [
                'idInmueble' => 1,
                'fechaInicio' => '2017-12-01',
                'fechaTerminoPropuesta' => '2018-12-01',
                'fechaTerminoReal' => '2018-12-01',
                'canon' => 300000,
                'rutInquilino' => '23397132-6',
                'diaPago' => 10,
                'estado' => false,
                'urlContrato' => null,
                'numeroRenovacion' => null
            ],
            [
                'idInmueble' => 1,
                'fechaInicio' => '2018-12-01',
                'fechaTerminoPropuesta' => '2019-12-01',
                'fechaTerminoReal' => '2019-12-01',
                'canon' => 350000,
                'rutInquilino' => '24765918-8',
                'diaPago' => 1,
                'estado' => true,
                'urlContrato' => null,
                'numeroRenovacion' => null
            ]
        ]);
        $arriendos = Arriendo::all();
        foreach($arriendos as $arriendo) {
            DeudaController::generar($arriendo);
        }
    }
}