<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    //tipo_comprobante
    const FACTURA = 1;
    const NOMINA = 2;
    const GASTOS = 3;
    const INGRESOS = 4;
    //estado_factura
    const PAGADA = 1;
    const ABONADA = 2;
    const PENDIENTE = 3;
    const ANULADA = 4;
    //TIPO PAGO
    const EFECTIVO = 1;
    const TARJETA = 2;
}
