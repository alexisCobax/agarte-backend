<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
</head>

<body>

    <header style="width: 100%; border-bottom: 2px solid #333; padding: 10px 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 33%; text-align: left;">{{nombre_sucursal}}</td>
                <td style="width: 33%; text-align: center; font-weight: bold;">
                    <h1>Recibo</h1>
                </td>
                <td style="width: 33%; text-align: right;">N°: 1</td>
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

        <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th style="text-align: center; width:500px;">Detalle</th>
                        <th style="text-align: center;">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pago con Tarjeta de Crédito</td>
                        <td style="text-align: center;">${{monto}}</td>
                    </tr>
                    <tr>
                        <td>Descuento</td>
                        <td style="text-align: center;">$00.00</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>${{total}}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>