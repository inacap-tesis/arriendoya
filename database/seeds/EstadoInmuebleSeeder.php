<?php

use Illuminate\Database\Seeder;

class EstadoInmuebleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados_inmueble')->delete();
        DB::table('estados_inmueble')->insert([
            ['id' => 1, 'nombre' => 'Registrado'],
            ['id' => 2, 'nombre' => 'Publicado'],
            ['id' => 3, 'nombre' => 'Dado de baja'],
            ['id' => 4, 'nombre' => 'Pendiente por arrendar'],
            ['id' => 5, 'nombre' => 'Pre-Arrendado'],
            ['id' => 6, 'nombre' => 'Arrendado'],
            ['id' => 7, 'nombre' => 'Post-Arrendado']
        ]);
    }
}
