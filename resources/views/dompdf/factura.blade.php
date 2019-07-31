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
        font-size: 13px;
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
                bottom:   8cm;
                left:     0cm;

                /** Change image dimensions**/
                width:    6cm;
                height:   6cm;

                /** Your watermark should be behind every content**/
                z-index:  -10;
            }
    </style>
    <body>
        <div class="ticket">
        @foreach ($factura as $fact)
            <center> <img src="img/logo/Logotipo2.png" alt="AgendaGrid" id="imagen"></center>
            {{-- @if ($fact->estado == 'Anulado')
                <div id="watermark">
                    <img src="img/anulado.png" height="100%" width="100%" />
                </div>
            @else --}}
                <!--<div id="watermark">
                    <img src="img/registrado.png" height="100%" width="100%" />
                </div>-->
            {{-- @endif --}}
            <p class="centrado">
                @foreach ($empresa as $em)
                <b>{{$em->nombre_empresa}}</b>
                <br>{{$em->direccion_empresa}}
                <br>{{$em->celular_empresa}} - {{$em->telefono_empresa}}
                @endforeach
            </p>
            <br><b>Número Factura: </b>{{$fact->numero_factura}}
            <br><b>Impresión: </b>{{DATE_FORMAT(now(), 'd/m/Y - h:i:s a')}}</p>
            <br><b>Cliente: </b>
            @if ($fact->nombre_cliente == '')
            {{$fact->nombre_anonimo}}
            @else
            {{$fact->nombre_cliente}}
            @endif
            </p>
            <table>
                <thead>
                    <tr>
                        <th id="fac">Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sr(a). {{$fact->numero_factura}}<br>
                        {{$fact->numero_factura}}: {{$fact->numero_factura}}<br>
                        Dirección: {{$fact->numero_factura}}<br>
                        Teléfono: {{$fact->numero_factura}}<br>
                        </td>
                    </tr>
                </tbody>
            </table>
        @endforeach
            <table>
                <thead>
                    <tr>
                        <th class="cantidad">CANT</th>
                        <th class="producto">PRODUCTO</th>
                        <th>VALOR U</th>
                        <th>VR. TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalleFactura as $det)
                    <tr>
                        <td class="cantidad">{{$det->cantidad_facturada}}</td>
                        <td class="producto">{{$det->nombre_servicio}}</td>
                        <td >{{$det->created_at}}</td>
                        <td ></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                        @foreach ($factura as $v)
                        <tr>
                            <th></th>
                            <th></th>
                            <th>SUBTOTAL</th>
                            <td>$ </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>IVA</th>
                            <td>$ </td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>TOTAL</th>
                            <td>$ {{$v->numero_factura}}</td>
                        </tr>
                        @endforeach
                    </tfoot>
            </table>
            <br><b>Vendido por: </b>{{$v->numero_factura}}
            <br><b>Fecha Venta: </b>{{DATE_FORMAT($v->created_at, 'd/m/Y - h:i:s a')}}
            <br>
            <p class="centrado"><b>¡GRACIAS POR TU COMPRA!</b>
            <br>gridsoft.co</p>
        </div>

    </body>
</html>
