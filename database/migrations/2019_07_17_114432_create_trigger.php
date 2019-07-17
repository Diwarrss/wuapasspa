<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER sumar_producido
            AFTER INSERT ON movimientos
            FOR EACH ROW
            BEGIN
                IF NEW.tipo_movimiento = 1 THEN BEGIN
                UPDATE cajas SET valor_producido = valor_producido + NEW.valor_movimiento
                WHERE cajas.id = NEW.caja_id;
                    END;
                ELSE BEGIN
                    UPDATE cajas SET valor_gastos = valor_gastos + NEW.valor_movimiento
                    WHERE cajas.id = NEW.caja_id;
                    END;
                END IF;
            END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER sumar_producido');
    }
}
