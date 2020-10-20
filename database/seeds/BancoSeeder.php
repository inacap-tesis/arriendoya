<?php

use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bancos')->delete();
        DB::table('bancos')->insert([
            ['id' => 1, 'nombre' =>  'BANCO DE CHILE'],
            ['id' => 2, 'nombre' =>  'BANCO INTERNACIONAL'],
            ['id' => 3, 'nombre' =>  'SCOTIABANK CHILE'],
            ['id' => 4, 'nombre' =>  'BANCO DE CREDITO E INVERSIONES'],
            ['id' => 5, 'nombre' =>  'CORPBANCA'],
            ['id' => 6, 'nombre' =>  'BANCO BICE'],
            ['id' => 7, 'nombre' =>  'HSBC BANK (CHILE'],
            ['id' => 8, 'nombre' =>  'BANCO SANTANDER-CHILE'],
            ['id' => 9, 'nombre' =>  'BANCO ITAÚ CHILE'],
            ['id' => 10, 'nombre' =>  'BANCO SECURITY'],
            ['id' => 11, 'nombre' =>  'BANCO FALABELLA'],
            ['id' => 12, 'nombre' =>  'DEUTSCHE BANK (CHILE'],
            ['id' => 13, 'nombre' =>  'BANCO RIPLEY'],
            ['id' => 14, 'nombre' =>  'RABOBANK CHILE'],
            ['id' => 15, 'nombre' =>  'BANCO CONSORCIO'],
            ['id' => 16, 'nombre' =>  'BANCO PENTA'],
            ['id' => 17, 'nombre' =>  'BANCO PARIS'],
            ['id' => 18, 'nombre' =>  'BANCO BILBAO VIZCAYA ARGENTARIA CHILE (BBVA)'],
            ['id' => 19, 'nombre' =>  'BANCO DEL ESTADO DE CHILE']
        ]);
    }
}
