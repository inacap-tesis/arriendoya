<?php

use Illuminate\Database\Seeder;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               
    }

    public static function up() {
        DB::table('provincias')->insert([
            ['id' => 1, 'nombre' => 'Arica', 'idRegion' => 1],
            ['id' => 2, 'nombre' => 'Parinacota', 'idRegion' => 1],
            ['id' => 3, 'nombre' => 'Iquique', 'idRegion' => 2],
            ['id' => 4, 'nombre' => 'El Tamarugal', 'idRegion' => 2],
            ['id' => 5, 'nombre' => 'Tocopilla', 'idRegion' => 3],
            ['id' => 6, 'nombre' => 'El Loa', 'idRegion' => 3],
            ['id' => 7, 'nombre' => 'Antofagasta', 'idRegion' => 3],
            ['id' => 8, 'nombre' => 'Chañaral', 'idRegion' => 4],
            ['id' => 9, 'nombre' => 'Copiapó', 'idRegion' => 4],
            ['id' => 10, 'nombre' => 'Huasco', 'idRegion' => 4],
            ['id' => 11, 'nombre' => 'Elqui', 'idRegion' => 5],
            ['id' => 12, 'nombre' => 'Limarí', 'idRegion' => 5],
            ['id' => 13, 'nombre' => 'Choapa', 'idRegion' => 5],
            ['id' => 14, 'nombre' => 'Petorca', 'idRegion' => 6],
            ['id' => 15, 'nombre' => 'Los Andes', 'idRegion' => 6],
            ['id' => 16, 'nombre' => 'San Felipe de Aconcagua', 'idRegion' => 6],
            ['id' => 17, 'nombre' => 'Quillota', 'idRegion' => 6],
            ['id' => 18, 'nombre' => 'Valparaiso', 'idRegion' => 6],
            ['id' => 19, 'nombre' => 'San Antonio', 'idRegion' => 6],
            ['id' => 20, 'nombre' => 'Isla de Pascua', 'idRegion' => 6],
            ['id' => 21, 'nombre' => 'Marga Marga', 'idRegion' => 6],
            ['id' => 22, 'nombre' => 'Chacabuco', 'idRegion' => 7],
            ['id' => 23, 'nombre' => 'Santiago', 'idRegion' => 7],
            ['id' => 24, 'nombre' => 'Cordillera', 'idRegion' => 7],
            ['id' => 25, 'nombre' => 'Maipo', 'idRegion' => 7],
            ['id' => 26, 'nombre' => 'Melipilla', 'idRegion' => 7],
            ['id' => 27, 'nombre' => 'Talagante', 'idRegion' => 7],
            ['id' => 28, 'nombre' => 'Cachapoal', 'idRegion' => 8],
            ['id' => 29, 'nombre' => 'Colchagua', 'idRegion' => 8],
            ['id' => 30, 'nombre' => 'Cardenal Caro', 'idRegion' => 8],
            ['id' => 31, 'nombre' => 'Curicó', 'idRegion' => 9],
            ['id' => 32, 'nombre' => 'Talca', 'idRegion' => 9],
            ['id' => 33, 'nombre' => 'Linares', 'idRegion' => 9],
            ['id' => 34, 'nombre' => 'Cauquenes', 'idRegion' => 9],
            ['id' => 35, 'nombre' => 'Diguillín', 'idRegion' => 10],
            ['id' => 36, 'nombre' => 'Itata', 'idRegion' => 10],
            ['id' => 37, 'nombre' => 'Punilla', 'idRegion' => 10],
            ['id' => 38, 'nombre' => 'Bio Bío', 'idRegion' => 11],
            ['id' => 39, 'nombre' => 'Concepción', 'idRegion' => 11],
            ['id' => 40, 'nombre' => 'Arauco', 'idRegion' => 11],
            ['id' => 41, 'nombre' => 'Malleco', 'idRegion' => 12],
            ['id' => 42, 'nombre' => 'Cautín', 'idRegion' => 12],
            ['id' => 43, 'nombre' => 'Valdivia', 'idRegion' => 13],
            ['id' => 44, 'nombre' => 'Ranco', 'idRegion' => 13],
            ['id' => 45, 'nombre' => 'Osorno', 'idRegion' => 14],
            ['id' => 46, 'nombre' => 'Llanquihue', 'idRegion' => 14],
            ['id' => 47, 'nombre' => 'Chiloé', 'idRegion' => 14],
            ['id' => 48, 'nombre' => 'Palena', 'idRegion' => 14],
            ['id' => 49, 'nombre' => 'Coyhaique', 'idRegion' => 15],
            ['id' => 50, 'nombre' => 'Aysén', 'idRegion' => 15],
            ['id' => 51, 'nombre' => 'General Carrera', 'idRegion' => 15],
            ['id' => 52, 'nombre' => 'Capitán Prat', 'idRegion' => 15],
            ['id' => 53, 'nombre' => 'Última Esperanza', 'idRegion' => 16],
            ['id' => 54, 'nombre' => 'Magallanes', 'idRegion' => 16],
            ['id' => 55, 'nombre' => 'Tierra del Fuego', 'idRegion' => 16],
            ['id' => 56, 'nombre' => 'Antártica Chilena', 'idRegion' => 16]
        ]);
        ComunaSeeder::up();
    }

    public static function down() {
        ComunaSeeder::down();
        DB::table('provincias')->delete();
    }

}
