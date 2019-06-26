<?php

use Illuminate\Database\Seeder;
use App\Servicio;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //se llama el modelo Servicio
        factory(Servicio::class, 10000)->create();       
    }
}
