<?php

use Faker\Generator as Faker;

$factory->define(App\Servicio::class, function (Faker $faker) {
    return [
        'empresas_empresas_id' => 1,
        'nombre_servicio' => $faker->name,
        'descripcion_servicio' => $faker->text,
        'estado_servicio' => 1,
    ];
});
