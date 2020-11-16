<?php

use Illuminate\Database\Seeder;

class GarantiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('garantias')->delete();
        DB::table('garantias')->insert([
            ['idArriendo' => 1, 'estado' => false, 'monto' => 300000, 'diasRetraso' => -1],
            ['idArriendo' => 2, 'estado' => false, 'monto' => 350000, 'diasRetraso' => -1]
        ]);
    }
}
