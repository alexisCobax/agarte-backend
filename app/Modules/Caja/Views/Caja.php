<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja</title>
</head>

<body>

    <header style="width: 100%; border-bottom: 2px solid #333; padding: 10px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; text-align: left;">{{nombre_sucursal}}</td>
                <td style="width: 33%; text-align: center; font-weight: bold;">
                    <h1>Caja</h1>
                </td>
                <td style="width: 33%; text-align: right;">N°: {{id_recibo}}</td>
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
            <thead>
                <tr>
                    <th style='text-align:left;'>Nº Recibo</th>
                    <th style='text-align:center;'>Nº OT</th>
                    <th style='text-align:center;'>Cliente</th>
                    <th style='text-align:center;'>Efectivo</th>
                    <th style='text-align:center;'>Tarjeta</th>
                    <th style='text-align:center;'>Transfer</th>
                    <th style='text-align:center;'>Total</th>
                </tr>
            </thead>
            <tbody style="border: 1px solid black;">
                {{tabla_caja}}
            </tbody>
            <tfoot>
        <tr style="border-top: 2px solid black;">
        <td colspan="3" style="text-align:left;  min-width: 50px; white-space: nowrap;">
                &nbsp;
            </td>
            <td colspan="1" style="text-align:left;  min-width: 50px; white-space: nowrap;">
                ${{total_efectivo}}
            </td>
            <td colspan="1" style="text-align:left;  min-width: 50px; white-space: nowrap;">
                ${{total_tarjeta}}
            </td>
        <td colspan="1" style="text-align:left;  min-width: 50px; white-space: nowrap;">
                ${{total_transferencia}}
            </td>
            <td colspan="1" style="text-align:left;  min-width: 50px; white-space: nowrap;">
                ${{total}}
            </td>
        </tr>
    </tfoot>

        </table>
    </div>
</body>

</html>