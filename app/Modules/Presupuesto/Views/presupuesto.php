<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto</title>
</head>

<body>

    <header style="width: 100%; border-bottom: 2px solid #333; padding: 10px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; text-align: left;">{{sucursal_nombre}}</td>
                <td style="width: 33%; text-align: center; font-weight: bold;">
                    <h1>Presupuesto</h1>
                </td>
                <td style="width: 33%; text-align: right;">N°: {{numero_presupuesto}}</td>
            </tr>
        </table>
    </header>

    <div class="container">
        <table>
            <tr>
                <td><strong>Nombre:</strong> {{cliente_nombre}}</td>
                <td><strong>Email:</strong> {{cliente_email}}</td>
            </tr>
            <tr>
                <td><strong>Domicilio:</strong> {{cliente_domicilio}}</td>
                <td><strong>Teléfono:</strong> {{cliente_telefono}}</td>
            </tr>
        </table>
        <hr />


        <table>
            <tr>
                <td><strong>Tipo:</strong> {{objeto_tipo}}</td>
                <td><strong>Tipo de Enmarcación:</strong> {{detalle_tipo}}</td>
            </tr>
            <tr>
                <td><strong>Modelo:</strong> {{objeto_modelo}}</td>
                <td><strong>Alto:</strong> {{detalle_alto}} cm</td>
            </tr>
            <tr>
                <td><strong>¿Es Propio?:</strong> {{objeto_propiedad}}</td>
                <td><strong>Ancho:</strong> {{detalle_ancho}} cm</td>
            </tr>
            <tr>
                <td><strong>Cantidad:</strong> {{cantidad}}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Comentario:</strong> {{objeto_comentario}}</td>
            </tr>
        </table>
        <br />
        <table>
            <thead>
                <tr>
                    <th style='text-align:left;'>Material</th>
                    <th style='text-align:center;'>Cm</th>
                    <th style='text-align:center;'>CS</th>
                    <th style='text-align:left;'>Observaciones</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                {{tabla_materiales}}
            </tbody>
            <tfoot>
                {{ if(descuento!='0.00') }}
                <tr>
                    <td colspan="4" style="text-align:right;  min-width: 150px; ">
                        <b>Descuento:</b> ${{descuento}}
                    </td>
                </tr>

                {{ else }}

                &nbsp;

                {{ endif }}
                <tr>
                <td colspan="4" style="text-align:right;  min-width: 150px; ">
                    <b>Total:</b> ${{total}}
                </td>
                </tr>
            </tfoot>

        </table>
        <p>Presupuesto válido por 15 días corridos desde la fecha de emisión. </p>
    </div>
</body>

</html>