<?php

use Illuminate\Database\Seeder;

class CategoriaNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias_notificacion')->delete();
        DB::table('categorias_notificacion')->insert([
            ['id' => 1, 'nombre' => 'Prueba']
        ]);
    }
}
