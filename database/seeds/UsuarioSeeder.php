<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->delete();
        DB::table('usuarios')->insert([
            [
                'rut' => '24765918-8', 
                'primerNombre' => 'Kevin',
                'segundoNombre' => '',
                'primerApellido' => 'Lopez',
                'segundoApellido' => 'Gonzalez',
                'fechaNacimiento' => Now(),
                'telefono' => '+5684452859',
                'urlFoto' => 'test.jpg',
                'email' => 'segad82@gmail.com',
                'password' => '$2y$10$2ghGNRJlQPgcvwO5cOln6ORHdo04G/R8RvR3chn02IXA5t6g4.8Ju'
            ],
            [
                'rut' => '23397132-4', 
                'primerNombre' => 'Ceyda',
                'segundoNombre' => '',
                'primerApellido' => 'Gonzalez',
                'segundoApellido' => 'Artunduaga',
                'fechaNacimiento' => Now(),
                'telefono' => '+5684452859',
                'urlFoto' => 'test.jpg',
                'email' => 'ceyda@arriendo.cl',
                'password' => '$2y$10$2ghGNRJlQPgcvwO5cOln6ORHdo04G/R8RvR3chn02IXA5t6g4.8Ju'
            ],
            [
                'rut' => '23397132-5', 
                'primerNombre' => 'Andrea',
                'segundoNombre' => 'Beatriz',
                'primerApellido' => 'Gonzalez',
                'segundoApellido' => 'Calderon',
                'fechaNacimiento' => Now(),
                'telefono' => '+5684452859',
                'urlFoto' => 'test.jpg',
                'email' => 'andrea@arriendo.cl',
                'password' => '$2y$10$2ghGNRJlQPgcvwO5cOln6ORHdo04G/R8RvR3chn02IXA5t6g4.8Ju'
            ],
            [
                'rut' => '23397132-6', 
                'primerNombre' => 'Jose',
                'segundoNombre' => 'Arley',
                'primerApellido' => 'Anchico',
                'segundoApellido' => 'Palomino',
                'fechaNacimiento' => Now(),
                'telefono' => '+5684452859',
                'urlFoto' => 'test.jpg',
                'email' => 'jose@arriendo.cl',
                'password' => '$2y$10$2ghGNRJlQPgcvwO5cOln6ORHdo04G/R8RvR3chn02IXA5t6g4.8Ju'
            ]
        ]);
    }
}
