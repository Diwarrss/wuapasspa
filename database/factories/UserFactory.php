<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Empresa;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'roles_idrol' => \App\Role::all()->random()->idrol,//accedemos a toda la informacion de Role y escogemos el idrol aleatorio
        'empresas_idempresa' => \App\Empresa::all()->random()->idempresa,
        'nombre_usuario' => $faker->randomElement(['Juan', 'Pedro', 'Luz']),
        'apellido_usuario' => $faker->randomElement(['Perez', 'Reyes', 'Diaz', 'Vargas']),
        'usuario' => $faker->name,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'email' => $faker->unique()->safeEmail,
        'celular' => $faker->phoneNumber,
        'fecha_cumple' => $faker->date,
        'imagen' => Faker\Provider\Image::image(storage_path().'app/public/user', 600, 350, 'people', false),
        'estado_usuario' => $faker->randomElement([\App\User::ACTIVO, \App\User::DESACTIVADO]),
        'email_verified_at' => now(),
        'remember_token' => Str::random(10),
    ];
});
