<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @foreach ($factura as $v)
    <title>Ticket de venta {{$v->numero_factura}}</title>
    @endforeach
    <style>
        body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        }

        td,
        th,
        tr,
        table {
        border-top: 1px solid black;
        border-collapse: collapse;
        }

        td.producto,
        th.producto {
        width: 75px;
        max-width: 75px;
        }

        td.cantidad,
        th.cantidad {
        width: 40px;
        max-width: 40px;
        word-break: break-all;
        }

        td.precio,
        th.precio {
        width: 40px;
        max-width: 40px;
        word-break: break-all;
        }

        .centrado {
        text-align: center;
        align-content: center;
        }

        .ticket {
        width: 250px;
        max-width: 250px;
        }

        #imagen{
        width: 150px;
        display: block;
        }

        #watermark {/*imagen de fondo marca de agua*/
                position: fixed;

                /**
                    Set a position in the page for your image
                    This should center it vertically
                **/
                bottom:   14cm;
                left:     0cm;

                /** Change image dimensions**/
                width:    6cm;
                height:   6cm;

                /** Your watermark should be behind every content**/
                z-index:  -10;
            }
    </style>
    <body style="margin:0;padding:0">
        <div class="ticket">
        @foreach ($factura as $fact)
            {{-- <center> <img src="img/logo/Logotipo2.png" alt="AgendaGrid" id="imagen"></center> --}}
            <div id="watermark">
                <img src="img/facture/anulado.png" height="100%" width="100%" />
            </div>
            <p class="centrado">
                @foreach ($empresa as $em)
                <b>{{$em->nombre_empresa}}</b>
                <br>{{$em->direccion_empresa}}
                <br>{{$em->celular_empresa}} - {{$em->telefono_empresa}}
                @endforeach
            </p>
            <b>Número Factura: </b>{{$fact->numero_factura}}
            <br><b>Impresión: </b>{{DATE_FORMAT(now(), 'd/m/Y - h:i:s a')}}</p>
            <br><b>Cliente: </b>{{$fact->nombre_cliente}}
        @endforeach
            <table>
                <thead>
                    <tr>
                        <th class="producto">Servicio</th>
                        <th class="cantidad">Cant.</th>
                        <th class="cantidad">Vr. Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleFactura as $det)
                    <tr>
                        <td class="producto">{{$det->nombre_servicio}}</td>
                        <td class="cantidad">{{$det->cantidad_facturada}}</td>
                        <td class="producto">${{number_format($det->valor_servicios,0, ',', '.' ) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                        @foreach ($factura as $fact)
                        <tr>
                            <th></th>
                            <th>Subtotal</th>
                            <td>${{number_format($fact->valor_total - $fact->valor_descuento,0, ',', '.' ) }}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Dto.</th>
                            <td>${{number_format($fact->valor_descuento,0, ',', '.' )}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Total</th>
                            <td>${{number_format($fact->valor_total,0, ',', '.' ) }}</td>
                        </tr>
                        @endforeach
                    </tfoot>
            </table>
            <br><b>Vendido por: </b>{{$v->nombre_facturador}}
            <br><b>Anulado por: </b>{{$v->nombre_anuladopor}}
            <br><b>Fecha Venta: </b>{{DATE_FORMAT($v->created_at, 'd/m/Y - h:i:s a')}}
            <br>
            <p class="centrado"><b>¡GRACIAS POR TU COMPRA!</b>
        </div>
    </body>
</html>
