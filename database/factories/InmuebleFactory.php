<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Inmueble;
use Faker\Generator as Faker;

$factory->define(Inmueble::class, function (Faker $faker) {
    return [
        'idTipoInmueble' => function () { return App\TipoInmueble::inRandomOrder()->first()->id; },
        'idEstado' => function () { return App\EstadoInmueble::inRandomOrder()->first()->id; },
        'idComuna' => function () { return App\Comuna::inRandomOrder()->first()->id; }, 
        'rutPropietario' => function () { return App\Usuario::inRandomOrder()->first()->rut; }, 
        'poblacionDireccion' => $faker->name,
        'calleDireccion' => $faker->name,
        'numeroDireccion' => $faker->randomDigit,
        'condominioDireccion' => $faker->name,
        'numeroDepartamentoDireccion' => $faker->name,
        'caracteristicas' => $faker->name
    ];
});
