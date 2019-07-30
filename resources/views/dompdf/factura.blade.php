<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @foreach ($factura as $v)
    <title>Ticket de venta {{$v->numero_factura}}-{{$v->numero_factura}}</title>
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
        @foreach ($factura as $v)
            <center> <img src="img/favicon.png" alt="GridSoft" id="imagen"></center>
            {{-- @if ($v->estado == 'Anulado')
                <div id="watermark">
                    <img src="img/anulado.png" height="100%" width="100%" />
                </div>          
            @else --}}
                <!--<div id="watermark">
                    <img src="img/registrado.png" height="100%" width="100%" />
                </div>--> 
            {{-- @endif --}}
            <p class="centrado">
                <b>GRIDSOFT</b>
                <br>Diego Vargas, San Gil - Santander
                <br>Celular: 313 245 8975
                <br>Email: dialvaro30@gmail.com 
            </p>
            <p><b>Tipo: </b>{{$v->numero_factura}}
            <br><b>Número Venta: </b>{{$v->numero_factura}} {{$v->numero_factura}}
            <br><b>Impresión: </b>{{DATE_FORMAT(now(), 'd/m/Y - h:i:s a')}}</p>
            <table>
                <thead>                        
                    <tr>
                        <th id="fac">Cliente</th>                      
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sr(a). {{$v->numero_factura}}<br>
                        {{$v->numero_factura}}: {{$v->numero_factura}}<br>
                        Dirección: {{$v->numero_factura}}<br>
                        Teléfono: {{$v->numero_factura}}<br>
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
                    @foreach ($factura as $det)
                    <tr>
                        <td class="cantidad">{{$det->numero_factura}}</td>
                        <td class="producto">{{$det->numero_factura}}</td>
                        <td >{{$det->numero_factura}}</td>
                        <td >{{$det->numero_factura*$det->numero_factura-$det->numero_factura}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                        @foreach ($venta as $v)
                        <tr>
                            <th></th>
                            <th></th>
                            <th>SUBTOTAL</th>
                            <td>$ {{round($v->numero_factura-($v->numero_factura*$v->numero_factura),2)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>IVA</th>
                            <td>$ {{round($v->numero_factura*$v->numero_factura,2)}}</td>
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