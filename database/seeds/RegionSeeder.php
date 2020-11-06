<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->down();
        $this->up();
    }

    public function up() {
        DB::table('regiones')->insert([
            ['id' => 1, 'nombre' => 'Arica y Parinacota', 'abreviatura' => 'AP', 'capital' => 'Arica'],
            ['id' => 2, 'nombre' => 'Tarapacá', 'abreviatura' => 'TA', 'capital' => 'Iquique'],
            ['id' => 3, 'nombre' => 'Antofagasta', 'abreviatura' => 'AN', 'capital' => 'Antofagasta'],
            ['id' => 4, 'nombre' => 'Atacama', 'abreviatura' => 'AT', 'capital' => 'Copiapó'],
            ['id' => 5, 'nombre' => 'Coquimbo', 'abreviatura' => 'CO', 'capital' => 'La Serena'],
            ['id' => 6, 'nombre' => 'Valparaiso', 'abreviatura' => 'VA', 'capital' => 'valparaíso'],
            ['id' => 7, 'nombre' => 'Metropolitana de Santiago', 'abreviatura' => 'RM', 'capital' => 'Santiago'],
            ['id' => 8, 'nombre' => 'Libertador General Bernardo O`Higgins', 'abreviatura' => 'OH', 'capital' => 'Rancagua'],
            ['id' => 9, 'nombre' => 'Maule', 'abreviatura' => 'MA', 'capital' => 'Talca'],
            ['id' => 10, 'nombre' => 'Ñuble', 'abreviatura' => 'NB', 'capital' => 'Chillán'],
            ['id' => 11, 'nombre' => 'Biobío', 'abreviatura' => 'BI', 'capital' => 'Concepción'],
            ['id' => 12, 'nombre' => 'La Araucanía', 'abreviatura' => 'IAR', 'capital' => 'Temuco'],
            ['id' => 13, 'nombre' => 'Los Ríos', 'abreviatura' => 'LR', 'capital' => 'Valdivia'],['id' => 14, 'nombre' => 'Los Lagos', 'abreviatura' => 'LL', 'capital' => 'Puerto Montt'],
            ['id' => 15, 'nombre' => 'Aysén del General Carlos Ibáñez del Campo', 'abreviatura' => 'AI', 'capital' => 'Coyhaique'],
            ['id' => 16, 'nombre' => 'Magallanes y de la Antártica Chilena', 'abreviatura' => 'MG', 'capital' => 'Punta Arenas']
        ]);
        ProvinciaSeeder::up();
    }

    public function down() {
        ProvinciaSeeder::down();
        DB::table('regiones')->delete();
    }

}
