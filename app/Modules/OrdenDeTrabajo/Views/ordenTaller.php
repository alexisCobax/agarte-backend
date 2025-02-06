<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden</title>
</head>

<body>

    <header style="width: 100%; border-bottom: 2px solid #333; padding: 10px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; text-align: left;">{{sucursal_nombre}}</td>
                <td style="width: 33%; text-align: center; font-weight: bold;">
                    <h1>Orden de trabajo</h1>
                </td>
                <td style="width: 33%; text-align: right;">N°: {{numero_orden}}</td>
            </tr>
        </table>
    </header>

    <div class="container">
        <table>
            <tr>
                <td><strong>Cliente:</strong> {{cliente_nombre}}</td>
            </tr>
        </table>
        <hr />


        <table>
            <tr>
                <td><strong>Tipo:</strong> {{nombre_objeto_enmarcar}}</td>
                <td><strong>Tipo de Enmarcación:</strong> {{detalle_tipo}}</td>
            </tr>
            <tr>
                <td><strong>Modelo:</strong> {{objeto_modelo}}</td>
                <td><strong>Alto:</strong> {{detalle_alto}} cm</td>
            </tr>
            <tr>
                <td><strong>Propiedad:</strong> {{objeto_propiedad}}</td>
                <td><strong>Ancho:</strong> {{detalle_ancho}} cm</td>
            </tr>
            <tr>
                <td><strong>Recepción:</strong> {{fecha_recepcion}}</td>
                <td><strong>Entrega:</strong> {{fecha_entrega}}</td>
            </tr>
            <tr>
                <td><strong>Cantidad:</strong> {{cantidad}}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Comentario:</strong> {{objeto_comentario}}</td>
            </tr>
        </table>
        <br/>
        <table border="1">
            <thead>
                <tr>
                    <th style='text-align:center;'>Material</th>
                    <th style='text-align:center;'>Cm</th>
                    <th style='text-align:center;'>CS</th>
                    <th style='text-align:center;'>Pos.</th>
                    <th style='text-align:center;'>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                {{tabla_materiales}}
            </tbody>
        </table>
    </div>
</body>

</html>