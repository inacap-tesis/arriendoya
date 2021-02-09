<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            BancoSeeder::class,
            RegionSeeder::class,
            TipoCuentaBancoSeeder::class,
            TipoInmuebleSeeder::class,
            EstadoInmuebleSeeder::class,
            //CategoriaNotificacionSeeder::class,
            UsuarioSeeder::class,
            InmuebleSeeder::class,
            ArriendoSeeder::class,
            GarantiaSeeder::class
        ]);
    }
}
