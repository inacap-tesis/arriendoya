<?php

use Illuminate\Database\Seeder;

class TipoInmuebleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_inmueble')->delete();
        DB::table('tipos_inmueble')->insert([
            ['id' => 1, 'nombre' => 'Casa'],
            ['id' => 2, 'nombre' => 'Departamento'],
            ['id' => 3, 'nombre' => 'Habitación']
        ]);
    }
}
