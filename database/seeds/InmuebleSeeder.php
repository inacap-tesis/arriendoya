<?php

use Illuminate\Database\Seeder;

class InmuebleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('inmuebles')->delete();
        DB::table('inmuebles')->insert([
            [
                'idTipoInmueble' => 1,
                'idEstado' => 6,
                'idComuna' => 17,
                'rutPropietario' => '23397132-4',
                'poblacionDireccion' => 'Bonilla',
                'calleDireccion' => 'Hector Rojas Albornoz',
                'numeroDireccion' => 9367,
                'condominioDireccion' => '',
                'numeroDepartamentoDireccion' => '',
                'caracteristicas' => 'Prueba'
            ],
            [
                'idTipoInmueble' => 2,
                'idEstado' => 6,
                'idComuna' => 17,
                'rutPropietario' => '23397132-5',
                'poblacionDireccion' => 'Nicolas Tirado',
                'calleDireccion' => 'El Yodo',
                'numeroDireccion' => 8265,
                'condominioDireccion' => 'Terramar 2',
                'numeroDepartamentoDireccion' => '121',
                'caracteristicas' => 'Prueba'
            ],
            [
                'idTipoInmueble' => 3,
                'idEstado' => 1,
                'idComuna' => 17,
                'rutPropietario' => '23397132-6',
                'poblacionDireccion' => '',
                'calleDireccion' => 'Maipú',
                'numeroDireccion' => 5641,
                'condominioDireccion' => '',
                'numeroDepartamentoDireccion' => '',
                'caracteristicas' => 'Prueba'
            ]
        ]);
    }
}
