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
            ['id' => 1, 'nombre' => 'Interes en anuncio'],
            ['id' => 2, 'nombre' => 'Desinteres en anuncio'],
            ['id' => 3, 'nombre' => 'Interesado rechazado'],
            ['id' => 4, 'nombre' => 'Interesado seleccionado'],
            ['id' => 5, 'nombre' => 'Interesado no seleccionado'],
            ['id' => 6, 'nombre' => 'Inmueble arrendado'],
            ['id' => 7, 'nombre' => 'Recordar pago de renta'],
            ['id' => 8, 'nombre' => 'Pago de renta'],
            ['id' => 9, 'nombre' => 'Problema con pago de renta'],
            ['id' => 10, 'nombre' => 'Pago de garantía'],
            ['id' => 11, 'nombre' => 'Problema con pago de garantía'],
            ['id' => 12, 'nombre' => 'Devolucion de garantía'],
            ['id' => 13, 'nombre' => 'Solicitud de finalización'],
            ['id' => 14, 'nombre' => 'Respuesta de solicitud finalización'],
            ['id' => 15, 'nombre' => 'Consulta renovación de arriendo'],
            ['id' => 16, 'nombre' => 'Respuesta a renovación de arriendo'],
            ['id' => 17, 'nombre' => 'Finalización de arriendo'],
            ['id' => 18, 'nombre' => 'Calificacion al inquilino'],
            ['id' => 19, 'nombre' => 'Calificación al arriendo'],
        ]);
    }
}
