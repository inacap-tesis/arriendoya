<?php

use Illuminate\Database\Seeder;

class TipoCuentaBancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_cuenta_bancaria')->delete();
        DB::table('tipos_cuenta_bancaria')->insert([
            ['id' => 1, 'nombre' => 'Ahorro'],
            ['id' => 2, 'nombre' => 'Corriente'],
            ['id' => 3, 'nombre' => 'Vista']
        ]);
    }
}
